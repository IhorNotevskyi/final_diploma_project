<?php

namespace App\Repository;

use App\Entity\Tag;
use Doctrine\ORM\EntityRepository;

class TagRepository extends EntityRepository
{
    public function deleteTag(Tag $tag)
    {
        return $this
            ->createQueryBuilder('tag')
            ->delete()
            ->where('tag.id = :id')
            ->setParameter('id', $tag)
            ->getQuery()
            ->getResult()
        ;
    }
}