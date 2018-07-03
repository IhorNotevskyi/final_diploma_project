<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    /**
     * @Route("/admin/products", name="product_list")
     * @Template()
     *
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        $queryBuilder = $this
            ->getDoctrine()
            ->getRepository('App:Product')
            ->createQueryBuilder('bp')
        ;

        if ($request->query->getAlnum('filter_category') || $request->query->getAlnum('filter_title') || $request->query->getAlnum('filter_description')) {
            $queryBuilder
                ->join('bp.category', 'category')
                ->where('category.name LIKE :category')
                ->andWhere('bp.title LIKE :title')
                ->andWhere('bp.description LIKE :description')
                ->setParameter('category', '%' . $request->query->getAlnum('filter_category') . '%')
                ->setParameter('title', '%' . $request->query->getAlnum('filter_title') . '%')
                ->setParameter('description', '%' . $request->query->getAlnum('filter_description') . '%')
            ;
        }

        $query = $queryBuilder->getQuery();

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator  = $this->get('knp_paginator');
        $products = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)
        );

        $categories = $this
            ->getDoctrine()
            ->getRepository('App:Category')
            ->createQueryBuilder('category')
            ->select('category.name')
            ->getQuery()
            ->getResult()
        ;

        return ['products' => $products, 'categories' => $categories];
    }

    /**
     * @Route("/admin/products/add", name="product_add")
     * @Template()
     *
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function addAction(Request $request, FileUploader $fileUploader)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->add('Save', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $file = $product->getImage();
            $fileName = $fileUploader->upload($file);
            $product->setImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Saved');

            return $this->redirectToRoute('product_add');
        }

        return ['product_form' => $form->createView()];
    }

    /**
     * @Route("/admin/products/{id}", name="product_edit", requirements={"id": "[0-9]+"})
     * @Template()
     *
     * @param Product $product
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function editAction(Product $product, Request $request, FileUploader $fileUploader)
    {
        $name = $product->getImage();


        $form = $this->createForm(ProductType::class, $product);
        $form->add('Save', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $file = $product->getImage();

            $imageName = $this
                ->getDoctrine()
                ->getRepository('App:Product')
                ->getImageByProduct($product)
            ;

            $imageFullPath = implode('', array_shift($imageName));
            $imagePath = SITE . DS . 'img' . DS;
            $image = str_replace($imagePath, "", $imageFullPath);

            $fileName = $fileUploader->upload($file);
            $product->setImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            unlink(ROOT . DS . 'img' . DS . $image);

            $this->addFlash('success', 'Saved');

            return $this->redirectToRoute('product_edit', ['id' => $product->getId()]);
        }

        return ['product' => $product, 'product_form' => $form->createView()];
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