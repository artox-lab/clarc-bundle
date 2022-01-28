<?php

/**
 * Extension of an ArtoxLabClarcExtension
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\DependencyInjection;

use ArtoxLab\Bundle\ClarcBundle\Core\UseCases\Commands\AbstractCommand;
use ArtoxLab\Bundle\ClarcBundle\Core\UseCases\Queries\AbstractQuery;
use Exception;
use InvalidArgumentException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class ArtoxLabClarcExtension extends Extension implements PrependExtensionInterface
{

    /**
     * Allow an extension to prepend the extension configurations.
     *
     * @param ContainerBuilder $container Container builder
     *
     * @return void
     */
    public function prepend(ContainerBuilder $container)
    {
        $this->prependFrameworkMessenger($container);
    }

    /**
     * Prepend configuration of symfony/messenger
     *
     * @param ContainerBuilder $container Container builder
     *
     * @return void
     */
    private function prependFrameworkMessenger(ContainerBuilder $container): void
    {
        $config = [
            'messenger' => [
                'default_bus' => 'command.bus',
                'buses'       => [
                    'command.bus' => [
                        'middleware' => ['artox_lab_clarc.bus.validation'],
                    ],
                    'query.bus'   => [
                        'middleware' => ['artox_lab_clarc.bus.validation'],
                    ],
                    'event.bus'   => [
                        'default_middleware' => 'allow_no_handlers',
                        'middleware'         => ['artox_lab_clarc.bus.validation'],
                    ],
                    'message.bus' => [
                        'default_middleware' => 'allow_no_handlers',
                        'middleware'         => ['artox_lab_clarc.bus.validation'],
                    ],
                    'listening.bus' => [
                        'default_middleware' => 'allow_no_handlers',
                    ],
                    'broadcasting.bus' => [
                        'default_middleware' => 'allow_no_handlers',
                        'middleware'         => [
                            'artox_lab_clarc.messenger.middleware.add_amqp_routing_key',
                        ],
                    ],
                ],
                'transports'  => [
                    'sync' => 'sync://',
                    'broadcasting' => [
                        'dsn' => '%env(BROADCASTING_MESSENGER_TRANSPORT_DSN)%',
                        'serializer' => 'artox_lab_clarc.messenger.transport.serializer.protobuf_self_origin_stamps',
                    ],
                    'listening' => [
                        'dsn' => '%env(LISTENING_MESSENGER_TRANSPORT_DSN)%',
                        'serializer' => 'artox_lab_clarc.messenger.transport.serializer.protobuf_self_origin_stamps',
                    ],
                    'failure_listening' => [
                        'dsn' => '%env(FAILURE_LISTENING_MESSENGER_TRANSPORT_DSN)%',
                        'serializer' => 'artox_lab_clarc.messenger.transport.serializer.protobuf',
                    ],
                ],
                'routing'     => [
                    AbstractCommand::class => 'sync',
                    AbstractQuery::class   => 'sync',
                    \Google\Protobuf\Internal\Message::class => 'broadcasting',
                ],
            ],
        ];

        $container->prependExtensionConfig('framework', $config);
    }

    /**
     * Loads a specific configuration.
     *
     * @param array            $configs   Configs
     * @param ContainerBuilder $container Container Builder
     *
     * @throws InvalidArgumentException When provided tag is not defined in this extension
     * @throws Exception
     *
     * @return void
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $this->loadApi(($config['api'] ?? []), $container);
        $this->loadSecurity($config['security'] ?? [], $container);
        $this->registerMessengerConfiguration($config['messenger'], $container);
    }

    /**
     * Load configuration for API
     *
     * @param array            $config    Config of API
     * @param ContainerBuilder $container Container Builder
     *
     * @return void
     */
    private function loadApi(array $config, ContainerBuilder $container): void
    {
        if (false === empty($config['serializer']['class'])) {
            $container->setParameter('artox_lab_clarc.api.serializer.class', $config['serializer']['class']);
        }
    }

    private function loadSecurity(array $config, ContainerBuilder $container)
    {
        $container
            ->getDefinition('artox_lab_clarc.security.rbac.permission_checker')
            ->replaceArgument(0, $config['rbac']['permissions'] ?? []);
    }

    private function registerMessengerConfiguration(array $config, ContainerBuilder $container): void
    {
        $transportBusMap = [
            'listening' => 'listening.bus',
        ];

        foreach ($config['transports'] as $transportId => $transport) {
            if (!$container->hasDefinition('messenger.transport.' . $transportId)) {
                throw new \RuntimeException(sprintf('Undefined transport with id "%s".', $transportId));
            }

            if (null !== $transport['bus']) {
                if (!$container->hasDefinition('messenger.bus.' . $transport['bus'])) {
                    throw new \RuntimeException(sprintf('Undefined message bus with id "%s".', $transport['bus']));
                }

                // Merge array to prevent redeclare required mapping.
                $transportBusMap += [$transportId => $transport['bus']];
            }
        }

        $container->getDefinition('artox_lab_clarc.messenger.listener.add_bus_name_stamp_listener')
            ->replaceArgument(0, $transportBusMap);
    }

}
