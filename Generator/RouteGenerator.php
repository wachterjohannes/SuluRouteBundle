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

use Symfony\Cmf\Bundle\CoreBundle\Slugifier\SlugifierInterface;

/**
 * This generator creates routes for entities and a schema.
 */
class RouteGenerator implements RouteGeneratorInterface
{
    /**
     * @var TokenProviderInterface
     */
    private $tokenProvider;

    /**
     * @var SlugifierInterface
     */
    private $slugifier;

    public function __construct(TokenProviderInterface $tokenProvider, SlugifierInterface $slugifier)
    {
        $this->tokenProvider = $tokenProvider;
        $this->slugifier = $slugifier;
    }

    /**
     * {@inheritdoc}
     */
    public function generate($entity, $routeSchema)
    {
        $tokens = [];
        preg_match_all('/{(.*?)}/', $routeSchema, $matches);
        $tokenNames = $matches[1];

        foreach ($tokenNames as $index => $name) {
            $tokenName = '{' . $name . '}';
            $tokenValue = $this->tokenProvider->provide($entity, $name);

            $tokens[$tokenName] = $this->slugifier->slugify($tokenValue);
        }

        $route = strtr($routeSchema, $tokens);
        if (0 !== strpos($route, '/')) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Generated non-absolute route "%s" for object "%s"',
                    $route,
                    get_class($entity)
                )
            );
        }
        return $route;
    }
}
