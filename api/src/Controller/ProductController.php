<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Service\FileUploader;
use Doctrine\Common\Collections\ArrayCollection;
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

        if (
            $request->query->getAlnum('filter_category') ||
            $request->query->getAlnum('filter_title') ||
            $request->query->getAlnum('filter_description') ||
            $request->query->getAlnum('filter_tags')
        ) {
            $queryBuilder
                ->join('bp.category', 'category')
                ->join('bp.tags', 'tags')
                ->where('category.name LIKE :category')
                ->andWhere('bp.title LIKE :title')
                ->andWhere('bp.description LIKE :description')
                ->andWhere('tags.name LIKE :tags')
                ->setParameter('category', '%' . $request->query->getAlnum('filter_category') . '%')
                ->setParameter('title', '%' . $request->query->getAlnum('filter_title') . '%')
                ->setParameter('description', '%' . $request->query->getAlnum('filter_description') . '%')
                ->setParameter('tags', '%' . $request->query->getAlnum('filter_tags') . '%')
            ;
        }

        $query = $queryBuilder
            ->orderBy('bp.id', 'DESC')
            ->getQuery()
        ;

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
            ->findAll()
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
        $form = $this->createForm(ProductType::class, $product, [
            'validation_groups' => ['Default', 'add_product']
        ]);
        $form->add('Save', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
// =========================================================================
            $originalTags = new ArrayCollection();
            foreach ($product->getTags() as $tag) {
                $originalTags->add($tag);
            }

            foreach ($originalTags as $tag) {
                $findTag = $this
                    ->getDoctrine()
                    ->getRepository('App:Tag')
                    ->findOneBy(['name' => $tag->getName()])
                ;

//                dump($tag->addProduct($product)); die;

                if ($findTag) {
                    continue;
                }
            }
// =========================================================================
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
        $em = $this->getDoctrine()->getManager();
        $originalTags = new ArrayCollection();

        foreach ($product->getTags() as $tag) {
            $originalTags->add($tag);
        }

        $form = $this->createForm(ProductType::class, $product, [
            'validation_groups' => ['Default']
        ]);
        $form->add('Save', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($originalTags as $tag) {
                if (false === $product->getTags()->contains($tag)) {
                    $tag->getProducts()->removeElement($product);
                    $em->persist($tag);

                    // if you wanted to delete the Tag entirely, you can also do that
                    $em->remove($tag);
                }
            }

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

            if ($file) {
                $fileName = $fileUploader->upload($file);
                $product->setImage($fileName);
            } else {
                $product->setImage($imageFullPath);
            }

            $em->persist($product);
            $em->flush();

            if ($file) {
                unlink($this->getParameter('image_directory') . DS . $image);
            }

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

        unlink($this->getParameter('image_directory') . DS . $image);

        return $this->redirectToRoute('product_list');
    }
}