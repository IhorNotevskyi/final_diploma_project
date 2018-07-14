<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Form\TagType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class TagController extends Controller
{
    /**
     * @Route("/admin/tags", name="tag_list")
     * @Template()
     *
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        $queryBuilder = $this
            ->getDoctrine()
            ->getRepository('App:Tag')
            ->createQueryBuilder('bp')
        ;

        if ($request->query->getAlnum('filter_tag')) {
            $queryBuilder
                ->where('bp.name LIKE :name')
                ->setParameter('name', '%' . $request->query->getAlnum('filter_tag') . '%')
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

        $tags = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)
        );

        $totalPages = ceil($tags->getTotalItemCount() / $tags->getItemNumberPerPage());
        if ($request->query->get('page') > $totalPages) {
            throw $this->createNotFoundException('The requested page was not found');
        }

        return ['tags' => $tags];
    }

    /**
     * @Route("/admin/tags/add", name="tag_add")
     * @Template()
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function addAction(Request $request)
    {
        $form = $this->createForm(TagType::class);
        $form->add('Save', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tag = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $em->flush();

            $this->addFlash('success', 'Saved');

            return $this->redirectToRoute('tag_add');
        }

        return ['tag_form' => $form->createView()];
    }

    /**
     * @Route("/admin/tags/edit/{id}", name="tag_edit", requirements={"id": "[0-9]+"})
     * @Template()
     *
     * @param Tag $tag
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function editAction(Tag $tag, Request $request)
    {
        $form = $this->createForm(TagType::class, $tag);
        $form->add('Save', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tag = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $em->flush();

            $this->addFlash('success', 'Saved');

            return $this->redirectToRoute('tag_edit', ['id' => $tag->getId()]);
        }

        return ['tag' => $tag, 'tag_form' => $form->createView()];
    }

    /**
     * @Route("/admin/tags/delete/{id}", name="tag_delete", requirements={"id": "[0-9]+"})
     * @Template()
     *
     * @param Tag $tag
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Tag $tag)
    {
        $this
            ->getDoctrine()
            ->getRepository('App:Tag')
            ->deleteTag($tag)
        ;

        return $this->redirectToRoute('tag_list');
    }
}