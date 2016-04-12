<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\RouteBundle\Generator;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * This token-provider uses a property-accessor to resolve tokens.
 */
class PropertyTokenProvider implements TokenProviderInterface
{
    /**
     * @var PropertyAccessorInterface
     */
    private $propertyAccessor;

    public function __construct()
    {
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * {@inheritdoc}
     */
    public function provide($entity, $name)
    {
        return $this->propertyAccessor->getValue($entity, $name);
    }
}
