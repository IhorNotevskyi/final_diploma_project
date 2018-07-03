<?php

namespace App\Repository;

use App\Entity\Callback;

class CallbackRepository extends \Doctrine\ORM\EntityRepository
{
    public function deleteCallback(Callback $callback)
    {
        return $this
            ->createQueryBuilder('callback')
            ->delete()
            ->where('callback.id = :id')
            ->setParameter('id', $callback)
            ->getQuery()
            ->getResult()
        ;
    }
}