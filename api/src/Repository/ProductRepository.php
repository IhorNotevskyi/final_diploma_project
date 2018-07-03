<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
	public function deleteProduct(Product $product)
    {
        return $this
            ->createQueryBuilder('product')
            ->delete()
            ->where('product.id = :id')
            ->setParameter('id', $product)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getImageByProduct(Product $product)
    {
        return $this
            ->createQueryBuilder('product')
            ->select('product.image')
            ->where('product.id = :id')
            ->setParameter('id', $product)
            ->getQuery()
            ->getResult()
        ;
    }
}