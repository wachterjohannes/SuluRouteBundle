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
 * Provides route-defaults for given entity-class and id.
 */
interface RouteDefaultsProviderInterface
{
    /**
     * Returns route-defaults for given entity-class and id.
     *
     * @param string $entityClass
     * @param string $id
     *
     * @return array
     */
    public function getByEntity($entityClass, $id);

    /**
     * Returns true if this provider supports given entity-class.
     *
     * @param string $entityClass
     *
     * @return bool
     */
    public function supports($entityClass);
}
