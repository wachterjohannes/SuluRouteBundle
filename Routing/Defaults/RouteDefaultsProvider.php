<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\RouteBundle\Routing\Defaults;

/**
 * Combines multiple defaults-provider.
 */
class RouteDefaultsProvider implements RouteDefaultsProviderInterface
{
    /**
     * @var RouteDefaultsProviderInterface[]
     */
    private $defaultsProvider;

    public function __construct(array $defaultsProvider)
    {
        $this->defaultsProvider = $defaultsProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function getByEntity($entityClass, $id)
    {
        if (!$this->supports($entityClass)) {
            return;
        }

        return $this->getDefaultProvider($entityClass)->getByEntity($entityClass, $id);
    }

    /**
     * {@inheritdoc}
     */
    public function supports($entityClass)
    {
        return null !== $this->getDefaultProvider($entityClass);
    }

    /**
     * {@inheritdoc}
     */
    private function getDefaultProvider($entityClass)
    {
        foreach ($this->defaultsProvider as $defaultsProvider) {
            if ($defaultsProvider->supports($entityClass)) {
                return $defaultsProvider;
            }
        }
    }
}
