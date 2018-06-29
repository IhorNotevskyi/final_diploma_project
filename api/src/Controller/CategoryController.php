<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    /**
     * @Route("/admin/categories", name="category_list")
     * @Template()
     */
    public function indexAction()
    {
        $categories = $this
            ->getDoctrine()
            ->getRepository('App:Category')
            ->findBy([], ['id' => 'DESC'])
        ;

        return ['categories' => $categories];
    }

    /**
     * @Route("/admin/categories/add", name="category_add")
     * @Template()
     *
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function addAction(Request $request, FileUploader $fileUploader)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->add('Save', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $file = $category->getImage();
            $fileName = $fileUploader->upload($file);
            $category->setImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'Saved');

            return $this->redirectToRoute('category_add');
        }

        return ['category_form' => $form->createView()];
    }

    /**
     * @Route("/admin/categories/{id}", name="category_edit", requirements={"id": "[0-9]+"})
     * @Template()
     *
     * @param Category $category
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function editAction(Category $category, Request $request, FileUploader $fileUploader)
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->add('Save', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $file = $category->getImage();

            $imageName = $this
                ->getDoctrine()
                ->getRepository('App:Category')
                ->getImageByCategory($category)
            ;

            $imageFullPath = implode('', array_shift($imageName));
            $imagePath = SITE . DS . 'img' . DS;
            $image = str_replace($imagePath, "", $imageFullPath);

            $fileName = $fileUploader->upload($file);
            $category->setImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            unlink(ROOT . DS . 'img' . DS . $image);

            $this->addFlash('success', 'Saved');

            return $this->redirectToRoute('category_edit', ['id' => $category->getId()]);
        }

        return ['category' => $category, 'category_form' => $form->createView()];
    }

    /**
     * @Route("/admin/categories/delete/{id}", name="category_delete", requirements={"id": "[0-9]+"})
     * @Template()
     *
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Category $category)
    {
        $imageName = $this
            ->getDoctrine()
            ->getRepository('App:Category')
            ->getImageByCategory($category)
        ;

        $imageFullPath = implode('', array_shift($imageName));
        $imagePath = SITE . DS . 'img' . DS;
        $image = str_replace($imagePath, "", $imageFullPath);

        $this
            ->getDoctrine()
            ->getRepository('App:Category')
            ->deleteCategory($category)
        ;

        unlink(ROOT . DS . 'img' . DS . $image);

        return $this->redirectToRoute('category_list');
    }
}