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
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class ArtoxLabClarcExtension extends Extension
{

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
        $config = $this->processConfiguration($configuration, $configs);

        $this->loadApi($config['api'] ?? [], $container);
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

}
