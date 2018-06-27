<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

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
            ->findBy([], ['id' => 'DESC'])
        ;

        return ['products' => $products];
    }

    /**
     * @Route("/admin/products/add", name="product_add")
     * @Template()
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function addAction(Request $request)
    {
        $form = $this->createForm(ProductType::class);
        $form->add('Save', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Saved');

            return $this->redirectToRoute('product_add');
        }

        return ['product_form' => $form->createView()];
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
        return ['product' => $product];
    }

    /**
     * @Route("/admin/products/delete/{id}", name="product_delete", requirements={"id": "[0-9]+"})
     * @Template()
     *
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Product $product)
    {
        $imageName = $this
            ->getDoctrine()
            ->getRepository('App:Product')
            ->getImageByProduct($product)
        ;

        $imageFullPath = implode('', array_shift($imageName));
        $imagePath = SITE . DS . 'img' . DS;
        $image = str_replace($imagePath, "", $imageFullPath);

        $this
            ->getDoctrine()
            ->getRepository('App:Product')
            ->deleteProduct($product)
        ;

        unlink(ROOT . DS . 'img' . DS . $image);

        return $this->redirectToRoute('product_list');
    }
}