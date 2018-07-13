<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class News extends EntityRepository
{

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getPublishedPostQuery()
    {
        $qb = $this->createQueryBuilder('n');
        $qb->where('n.isPublished = true');
        $qb->orderBy('n.publishedDate','DESC');

        return $qb;
    }
}