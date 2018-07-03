<?php

namespace App\Repository;

use App\Entity\User;

class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function deleteUser(User $user)
    {
        return $this
            ->createQueryBuilder('user')
            ->delete()
            ->where('user.id = :id')
            ->setParameter('id', $user)
            ->getQuery()
            ->getResult()
        ;
    }
}
