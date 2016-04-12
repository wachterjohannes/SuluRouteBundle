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

use Sulu\Component\Persistence\Repository\ORM\EntityRepository;

/**
 * Contains special queries to find routes.
 */
class RouteRepository extends EntityRepository implements RouteRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findByPath($path, $locale)
    {
        return $this->findOneBy(['path' => $path, 'locale' => $locale]);
    }
}
