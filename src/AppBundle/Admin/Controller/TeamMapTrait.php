<?php

namespace AppBundle\Admin\Controller;

use AppBundle\Entity\TeamMap;
use Doctrine\ORM\EntityManager;

trait TeamMapTrait
{
    /**
     * try to fetch a map
     *
     * @return null|TeamMap
     */
    public function fetchMap()
    {
        /** @var EntityManager $em */
        $em       = $this->getDoctrine()->getManager();
        $entities = $em->getRepository(TeamMap::class)->findAll();
        if ($entities) {
            return current($entities);
        }

        return null;
    }
}