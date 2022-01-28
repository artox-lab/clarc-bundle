<?php

/**
 * Configuration of bundle
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\DependencyInjection;

use ArtoxLab\Bundle\ClarcBundle\ArtoxLabClarcBundle;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder() : TreeBuilder
    {
        $treeBuilder = new TreeBuilder(ArtoxLabClarcBundle::CONFIG_BUNDLE_NAMESPACE);

        $this->getRootNode($treeBuilder)
            ->children()
                ->arrayNode('api')
                    ->children()
                        ->arrayNode('serializer')
                            ->children()
                                ->scalarNode('class')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->children()
                ->arrayNode('security')
                    ->children()
                        ->arrayNode('rbac')
                            ->children()
                                ->arrayNode('permissions')
                                    ->isRequired()
                                    ->useAttributeAsKey('name')
                                    ->arrayPrototype()
                                        ->prototype('scalar')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->arrayNode('messenger')
                ->addDefaultsIfNotSet()
                ->children()
                    ->arrayNode('transports')
                        ->normalizeKeys(false)
                        ->useAttributeAsKey('name')
                        ->arrayPrototype()
                            ->children()
                                ->scalarNode('bus')->defaultNull()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }

    /**
     * Getting root node of configuration with symfony 3.4 compatibility
     *
     * @param TreeBuilder $treeBuilder TreeBuilder
     *
     * @return ArrayNodeDefinition|NodeDefinition
     */
    protected function getRootNode(TreeBuilder $treeBuilder)
    {
        if (true === method_exists($treeBuilder, 'getRootNode')) {
            return $treeBuilder->getRootNode();
        }

        return $treeBuilder->root(ArtoxLabClarcBundle::CONFIG_BUNDLE_NAMESPACE);
    }

}
