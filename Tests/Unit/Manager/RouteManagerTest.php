<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\RouteBundle\Tests\Unit\Manager;

use Sulu\Bundle\RouteBundle\Entity\RouteRepositoryInterface;
use Sulu\Bundle\RouteBundle\Generator\RouteGeneratorInterface;
use Sulu\Bundle\RouteBundle\Manager\ConflictResolverInterface;
use Sulu\Bundle\RouteBundle\Manager\RouteAlreadyCreatedException;
use Sulu\Bundle\RouteBundle\Manager\RouteManager;
use Sulu\Bundle\RouteBundle\Model\RoutableInterface;
use Sulu\Bundle\RouteBundle\Model\RouteInterface;

class RouteManagerTest extends \PHPUnit_Framework_TestCase
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
     * @var RouteManager
     */
    private $manager;

    /**
     * @var RoutableInterface
     */
    private $entity;

    protected function setUp()
    {
        $this->entity = $this->prophesize(RoutableInterface::class);
        $this->mappings = [get_class($this->entity->reveal()) => ['route_schema' => '/{title}']];

        $this->routeGenerator = $this->prophesize(RouteGeneratorInterface::class);
        $this->routeRepository = $this->prophesize(RouteRepositoryInterface::class);
        $this->conflictResolver = $this->prophesize(ConflictResolverInterface::class);

        $this->manager = new RouteManager(
            $this->routeGenerator->reveal(),
            $this->routeRepository->reveal(),
            $this->conflictResolver->reveal(),
            $this->mappings
        );
    }

    public function testCreate()
    {
        $route = $this->prophesize(RouteInterface::class);
        $route->setPath('/test')->shouldBeCalled()->willReturn($route->reveal());
        $route->setEntityClass(get_class($this->entity->reveal()))->shouldBeCalled()->willReturn($route->reveal());
        $route->setEntityId('1')->shouldBeCalled()->willReturn($route->reveal());
        $route->setLocale('de')->shouldBeCalled()->willReturn($route->reveal());

        $this->entity->getId()->willReturn('1');
        $this->entity->getLocale()->willReturn('de');
        $this->entity->getRoute()->willReturn(null);
        $this->entity->setRoute($route->reveal())->shouldBeCalled();

        $this->routeGenerator->generate($this->entity->reveal(), '/{title}')->willReturn('/test');
        $this->routeRepository->createNew()->willReturn($route->reveal());
        $this->conflictResolver->resolve($route->reveal())->willReturn($route->reveal());

        $this->assertEquals($route->reveal(), $this->manager->create($this->entity->reveal()));
    }

    public function testCreateAlreadyExists()
    {
        $this->setExpectedException(RouteAlreadyCreatedException::class);

        $route = $this->prophesize(RouteInterface::class);
        $this->entity->getRoute()->willReturn($route->reveal());
        $this->entity->getId()->willReturn('1');

        $this->manager->create($this->entity->reveal());
    }

    public function testCreateWithConflict()
    {
        $route = $this->prophesize(RouteInterface::class);
        $route->setPath('/test')->shouldBeCalled()->willReturn($route->reveal());
        $route->setEntityClass(get_class($this->entity->reveal()))->shouldBeCalled()->willReturn($route->reveal());
        $route->setEntityId('1')->shouldBeCalled()->willReturn($route->reveal());
        $route->setLocale('de')->shouldBeCalled()->willReturn($route->reveal());

        $conflict = $this->prophesize(RouteInterface::class);

        $this->entity->getId()->willReturn('1');
        $this->entity->getLocale()->willReturn('de');
        $this->entity->getRoute()->willReturn(null);
        $this->entity->setRoute($conflict->reveal())->shouldBeCalled();

        $this->routeGenerator->generate($this->entity->reveal(), '/{title}')->willReturn('/test');
        $this->routeRepository->createNew()->willReturn($route->reveal());
        $this->conflictResolver->resolve($route->reveal())->willReturn($conflict->reveal());

        $this->assertEquals($conflict->reveal(), $this->manager->create($this->entity->reveal()));
    }
}
