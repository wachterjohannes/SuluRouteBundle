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

use Sulu\Bundle\RouteBundle\Entity\RouteRepositoryInterface;
use Sulu\Bundle\RouteBundle\Generator\RouteGeneratorInterface;
use Sulu\Bundle\RouteBundle\Model\RoutableInterface;

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

    /**
     * @var ConflictResolverInterface
     */
    private $conflictResolver;

    /**
     * @param RouteGeneratorInterface   $routeGenerator
     * @param RouteRepositoryInterface  $routeRepository
     * @param ConflictResolverInterface $conflictResolver
     * @param array                     $mappings
     */
    public function __construct(
        RouteGeneratorInterface $routeGenerator,
        RouteRepositoryInterface $routeRepository,
        ConflictResolverInterface $conflictResolver,
        array $mappings
    ) {
        $this->routeGenerator = $routeGenerator;
        $this->routeRepository = $routeRepository;
        $this->conflictResolver = $conflictResolver;
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

        $path = $this->routeGenerator->generate($entity, $this->mappings[get_class($entity)]['route_schema']);
        $route = $this->routeRepository->createNew()
            ->setPath($path)
            ->setEntityClass(get_class($entity))
            ->setEntityId($entity->getId())
            ->setLocale($entity->getLocale());

        $route = $this->conflictResolver->resolve($route);
        $entity->setRoute($route);

        return $route;
    }
}
