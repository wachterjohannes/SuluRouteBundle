<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\RouteBundle\Manager;

use Sulu\Bundle\RouteBundle\Model\RoutableInterface;
use Sulu\Bundle\RouteBundle\Entity\RouteRepositoryInterface;
use Sulu\Bundle\RouteBundle\Generator\RouteGeneratorInterface;

/**
 * Manages routes.
 */
class RouteManager implements RouteManagerInterface
{
    /**
     * @var array
     */
    private $mappings;

    /**
     * @var RouteGeneratorInterface
     */
    private $routeGenerator;

    /**
     * @var RouteRepositoryInterface
     */
    private $routeRepository;

    public function __construct(
        RouteGeneratorInterface $routeGenerator,
        RouteRepositoryInterface $routeRepository,
        array $mappings
    ) {
        $this->routeGenerator = $routeGenerator;
        $this->routeRepository = $routeRepository;
        $this->mappings = $mappings;
    }

    /**
     * {@inheritdoc}
     */
    public function create(RoutableInterface $entity)
    {
        if (null !== $entity->getRoute()) {
            throw new RouteAlreadyCreatedException($entity);
        }

        $route = $this->routeGenerator->generate($entity, $this->mappings[get_class($entity)]['route_schema']);
        $routeEntity = $this->routeRepository->createNew()
            ->setRoute($route)
            ->setEntityClass(get_class($entity))
            ->setEntityId($entity->getId())
            ->setLocale($entity->getLocale());

        // TODO resolve conflicts

        $entity->setRoute($routeEntity);

        return $routeEntity;
    }
}
