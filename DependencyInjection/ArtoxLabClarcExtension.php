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
                ],
                'transports'  => ['sync' => 'sync://'],
                'routing'     => [
                    AbstractCommand::class => 'sync',
                    AbstractQuery::class   => 'sync',
                ],
            ],
        ];

        $container->prependExtensionConfig('framework', $config);
    }

    /**
     * Loads a specific configuration.
     *
     * @param array<mixed>     $configs   Configs
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
    }

    /**
     * Load configuration for API
     *
     * @param array<mixed>     $config    Config of API
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

}
