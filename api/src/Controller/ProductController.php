<?php

namespace App\Controller;

use App\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    /**
     * @Route("/admin/products", name="product_list")
     * @Template()
     */
    public function indexAction()
    {
        $products = $this
            ->getDoctrine()
            ->getRepository('App:Product')
            ->findAll()
        ;

        return ['products' => $products];
    }

    /**
     * @Route("/admin/products/edit/{id}", name="product_edit", requirements={"id": "[0-9]+"})
     * @Template()
     *
     * @param Product $product
     * @return array
     */
    public function editAction(Product $product)
    {
//        $tags = $product->getTags()->toArray();
//        dump($tags);

        return ['product' => $product];
    }
}