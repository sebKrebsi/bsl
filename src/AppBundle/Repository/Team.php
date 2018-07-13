<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Team as Entity;
use Doctrine\ORM\EntityRepository;

class Team extends EntityRepository
{

    /**
     * @return Entity[]
     */
    public function getTeams()
    {
        $qb = $this->createQueryBuilder('t');
        $qb->orderBy('t.position', 'ASC');

        return $qb->getQuery()->execute();
    }
}