<?php
/**
 * Extension of an ArtoxLabClarcExtension
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\DependencyInjection;

use Exception as Exception;
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
     * Loads a specific configuration.
     *
     * @param array            $configs   Configs
     * @param ContainerBuilder $container Container Builder
     *
     * @return void
     *
     * @throws InvalidArgumentException When provided tag is not defined in this extension
     * @throws Exception
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
     * @param array            $config    Config of API
     * @param ContainerBuilder $container Container Builder
     *
     * @return void
     */
    protected function loadApi(array $config, ContainerBuilder $container) : void
    {
        if (empty($config['serializer']['class']) === false) {
            $container->setParameter('artox_lab_clarc.api.serializer.class', $config['serializer']['class']);
        }
    }

    /**
     * Prepend configuration of symfony/messenger
     *
     * @param ContainerBuilder $container Container builder
     *
     * @return void
     */
    protected function prependFrameworkMessenger(ContainerBuilder $container) : void
    {
        $config = [
            'messenger' => [
                'transports' => ['sync' => 'sync://'],
                'routing'    => [
                    'ArtoxLab\Bundle\ClarcBundle\Core\UseCases\Commands\AbstractCommand' => 'sync',
                    'ArtoxLab\Bundle\ClarcBundle\Core\UseCases\Queries\AbstractQuery'    => 'sync',
                ],
                'buses'      => [
                    'command.bus' => [
                        'middleware' => ['artox_lab_clarc.command_bus.validation'],
                    ],
                    'event.bus'   => [
                        'middleware' => ['artox_lab_clarc.command_bus.validation'],
                    ],
                    'query.bus'   => [
                        'middleware' => ['artox_lab_clarc.command_bus.validation'],
                    ],
                ],
            ],
        ];

        $container->prependExtensionConfig('framework', $config);
    }

}
