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

        $totalPages = ceil($products->getTotalItemCount() / $products->getItemNumberPerPage());
        if ($request->query->get('page') > $totalPages) {
            throw $this->createNotFoundException('The requested page was not found');
        }

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

            foreach ($product->getTags() as $tag) {
                $findTag = $this
                    ->getDoctrine()
                    ->getRepository('App:Tag')
                    ->findOneBy(['name' => $tag->getName()])
                ;

                if ($tag->getName() === null) $product->removeTag($tag);
                elseif (!$findTag) continue;
                elseif ($findTag) $product->removeTag($tag)->addTag($findTag);
            }

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
        $originalTags = new ArrayCollection();
        $tagsArray = [];
        foreach ($product->getTags() as $tag) {
            $originalTags->add($tag);
            $tagsArray[] = $tag->getName();
        }

        $form = $this->createForm(ProductType::class, $product, [
            'validation_groups' => ['Default']
        ]);
        $form->add('Save', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            foreach ($originalTags as $tag) {
                if (false === $product->getTags()->contains($tag)) {
                    $tag->getProducts()->removeElement($product);
                    $em->persist($tag);
                }
            }

            $product = $form->getData();

            $newTagsArray = [];
            foreach ($product->getTags() as $tag) {
                $newTagsArray[] = $tag->getName();

                $findTag = $this
                    ->getDoctrine()
                    ->getRepository('App:Tag')
                    ->findOneBy(['name' => $tag->getName()])
                ;

                if ($tag->getName() === null) $product->removeTag($tag);
                elseif (!$findTag) continue;
                elseif ($findTag) $product->removeTag($tag)->addTag($findTag);
            }

            foreach ($tagsArray as $tag) {
                if (false === in_array($tag, $newTagsArray)) {
                    $findTag = $this
                        ->getDoctrine()
                        ->getRepository('App:Tag')
                        ->findOneBy(['name' => $tag])
                    ;

                   if (count($findTag->getProducts()) === 0) {
                       $em->remove($findTag);
                   }
                }
            }

            $file = $product->getImage();

            $imageName = $this
                ->getDoctrine()
                ->getRepository('App:Product')
                ->getImageByProduct($product)
            ;

            $imageFullPath = implode('', array_shift($imageName));
            $image = str_replace($fileUploader::IMG_PATH, "", $imageFullPath);

            if ($file) {
                $fileName = $fileUploader->upload($file);
                $product->setImage($fileName);
            } else {
                $product->setImage($imageFullPath);
            }

            $em->persist($product);
            $em->flush();

            if ($file) {
                unlink($this->getParameter('image_directory') . DIRECTORY_SEPARATOR . $image);
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
        $image = str_replace(FileUploader::IMG_PATH, "", $imageFullPath);

        $tagsWithoutRelations = new ArrayCollection();

        foreach ($product->getTags() as $tag) {
            if (count($tag->getProducts()
                    ->filter(function(Product $product) {
                        return $product;
                    })
            ) === 1) {
                $tagsWithoutRelations->add($tag);
            }
        }

        $this
            ->getDoctrine()
            ->getRepository('App:Product')
            ->deleteProduct($product)
        ;

        $em = $this->getDoctrine()->getManager();
        foreach ($tagsWithoutRelations as $tag) {
            $em->remove($tag);
        }
        $em->flush();

        unlink($this->getParameter('image_directory') . DIRECTORY_SEPARATOR . $image);

        return $this->redirectToRoute('product_list');
    }
}