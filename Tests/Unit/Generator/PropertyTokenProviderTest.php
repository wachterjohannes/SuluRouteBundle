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

use Sulu\Bundle\RouteBundle\Generator\PropertyTokenProvider;
use Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException;

class PropertyTokenProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testProvide()
    {
        $entity = new \stdClass();
        $entity->title = 'test';

        $provider = new PropertyTokenProvider();

        $this->assertEquals('test', $provider->provide($entity, 'title'));
    }

    public function testProvideNotExists()
    {
        $this->setExpectedException(NoSuchPropertyException::class);

        $entity = new \stdClass();
        $entity->title = 'test';

        $provider = new PropertyTokenProvider();

        $this->assertEquals('test', $provider->provide($entity, 'name'));
    }
}
