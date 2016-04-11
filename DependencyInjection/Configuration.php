<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\RouteBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration definition of sulu_route.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $treeBuilder->root('sulu_route')
            ->children()
                ->arrayNode('mappings')
                    ->useAttributeAsKey('className')
                    ->prototype('array')
                    ->children()
                        ->scalarNode('route_schema')->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
