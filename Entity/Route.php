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
 * Represents a route in the route-pool.
 */
class Route
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $route;

    /**
     * @var string
     */
    private $webspaceKey;

    /**
     * @var string
     */
    private $entityClass;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set route.
     *
     * @param string $route
     *
     * @return Route
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route.
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set webspaceKey.
     *
     * @param string $webspaceKey
     *
     * @return Route
     */
    public function setWebspaceKey($webspaceKey)
    {
        $this->webspaceKey = $webspaceKey;

        return $this;
    }

    /**
     * Get webspaceKey.
     *
     * @return string
     */
    public function getWebspaceKey()
    {
        return $this->webspaceKey;
    }

    /**
     * Get entityClass.
     *
     * @return string
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * Set entityClass.
     *
     * @param string $entityClass
     *
     * @return Route
     */
    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;

        return $this;
    }
}
