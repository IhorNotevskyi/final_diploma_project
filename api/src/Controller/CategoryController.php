<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
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
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function addAction(Request $request)
    {
        $form = $this->createForm(CategoryType::class);
        $form->add('Save', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();

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
     * @return array
     */
    public function editAction(Category $category)
    {
        return ['category' => $category];
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