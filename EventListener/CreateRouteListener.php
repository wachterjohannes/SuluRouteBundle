<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\RouteBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Sulu\Bundle\RouteBundle\Model\RoutableInterface;
use Sulu\Bundle\RouteBundle\Manager\RouteManagerInterface;

/**
 * This listener will be called after persist and creates routes for new created routable entities.
 */
class CreateRouteListener
{
    /**
     * @var RouteManagerInterface
     */
    private $manager;

    public function __construct(RouteManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * This function will be called after persist.
     *
     * @param LifecycleEventArgs $eventArgs
     */
    public function postPersist(LifecycleEventArgs $eventArgs)
    {
        if (!$eventArgs->getEntity() instanceof RoutableInterface) {
            return;
        }

        $routeEntity = $this->manager->create($eventArgs->getEntity());
        $eventArgs->getEntityManager()->persist($routeEntity);
        $eventArgs->getEntityManager()->flush($routeEntity);
    }
}
