<?php

namespace App\Repository;

use App\Entity\Category;

class CategoryRepository extends \Doctrine\ORM\EntityRepository
{
    public function deleteCategory(Category $category)
    {
        return $this
            ->createQueryBuilder('category')
            ->delete()
            ->where('category.id = :id')
            ->setParameter('id', $category)
            ->getQuery()
            ->getResult()
            ;
    }

    public function getImageByCategory(Category $category)
    {
        return $this
            ->createQueryBuilder('category')
            ->select('category.image')
            ->where('category.id = :id')
            ->setParameter('id', $category)
            ->getQuery()
            ->getResult()
            ;
    }
}