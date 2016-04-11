<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\RouteBundle\Tests\Unit\Generator;

use Sulu\Bundle\RouteBundle\Generator\RouteGenerator;
use Sulu\Bundle\RouteBundle\Generator\TokenProviderInterface;
use Sulu\Bundle\RouteBundle\Model\RoutableInterface;
use Symfony\Cmf\Bundle\CoreBundle\Slugifier\SlugifierInterface;

class RouteGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TokenProviderInterface
     */
    private $tokenProvider;

    /**
     * @var SlugifierInterface
     */
    private $slugifier;

    /**
     * @var RouteGenerator
     */
    private $generator;

    public function setUp()
    {
        $this->tokenProvider = $this->prophesize(TokenProviderInterface::class);
        $this->slugifier = $this->prophesize(SlugifierInterface::class);

        $this->generator = new RouteGenerator($this->tokenProvider->reveal(), $this->slugifier->reveal());
    }

    public function testGenerate()
    {
        $entity = $this->prophesize(RoutableInterface::class);

        $this->tokenProvider->provide($entity->reveal(), 'title')->willReturn('Test Title');
        $this->tokenProvider->provide($entity->reveal(), 'id')->willReturn(1);

        $this->slugifier->slugify('Test Title')->willReturn('test-title');
        $this->slugifier->slugify(1)->willReturn('1');

        $path = $this->generator->generate($entity->reveal(), '/prefix/{title}/postfix/{id}');

        $this->assertEquals('/prefix/test-title/postfix/1', $path);
    }
}
