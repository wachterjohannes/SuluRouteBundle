<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\RouteBundle\DependencyInjection\CompilerPass;

use Sulu\Component\HttpKernel\SuluKernel;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * This class collects all services with the "sulu_route.defaults_provider" tag.
 */
class DefaultsProviderCompilerPass implements CompilerPassInterface
{
    const SERVICE_ID = 'sulu_route.routing.defaults_provider';
    const TAG_NAME = 'sulu_route.defaults_provider';

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (SuluKernel::CONTEXT_WEBSITE !== $container->getParameter('sulu.context')) {
            return;
        }

        $references = [];
        foreach ($container->findTaggedServiceIds(self::TAG_NAME) as $id => $tags) {
            foreach ($tags as $attributes) {
                $priority = array_key_exists('priority', $attributes) ? $attributes['priority'] : 0;
                $references[$priority][] = new Reference($id);
            }
        }

        if (0 === count($references)) {
            return;
        }

        krsort($references);
        $references = call_user_func_array('array_merge', $references);

        $container->getDefinition(self::SERVICE_ID)->replaceArgument(0, $references);
    }
}
