<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\RouteBundle\Entity;

/**
 * Contains special queries to find routes.
 */
interface RouteRepositoryInterface
{
    /**
     * Returns new route entity.
     *
     * @return Route
     */
    public function createNew();

    /**
     * Returns route-entity by route.
     *
     * @param string $route
     * @param string $localization
     *
     * @return Route
     */
    public function findByRoute($route, $localization);
}
