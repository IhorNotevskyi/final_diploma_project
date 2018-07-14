<?php

namespace App\Controller;

use App\Entity\Callback;
use App\Form\CallbackType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class CallbackController extends Controller
{
    /**
     * @Route("/admin/callbacks", name="callback_list")
     * @Template()
     *
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        $queryBuilder = $this
            ->getDoctrine()
            ->getRepository('App:Callback')
            ->createQueryBuilder('bp')
        ;

        if (
            $request->query->getAlnum('filter_name') ||
            $request->query->getAlnum('filter_phone') ||
            $request->query->getAlnum('filter_message')
        ) {
            $queryBuilder
                ->where('bp.name LIKE :name')
                ->andWhere('bp.phone LIKE :phone')
                ->andWhere('bp.message LIKE :message')
                ->setParameter('name', '%' . $request->query->getAlnum('filter_name') . '%')
                ->setParameter('phone', '%' . $request->query->getAlnum('filter_phone') . '%')
                ->setParameter('message', '%' . $request->query->getAlnum('filter_message') . '%')
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

        $callbacks = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)
        );

        $totalPages = ceil($callbacks->getTotalItemCount() / $callbacks->getItemNumberPerPage());
        if ($request->query->get('page') > $totalPages) {
            throw $this->createNotFoundException('The requested page was not found');
        }

        return ['callbacks' => $callbacks];
    }

    /**
     * @Route("/admin/callbacks/add", name="callback_add")
     * @Template()
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function addAction(Request $request)
    {
        $form = $this->createForm(CallbackType::class);
        $form->add('Save', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $callback = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($callback);
            $em->flush();

            $this->addFlash('success', 'Saved');

            return $this->redirectToRoute('callback_add');
        }

        return ['callback_form' => $form->createView()];
    }

    /**
     * @Route("/admin/callbacks/edit/{id}", name="callback_edit", requirements={"id": "[0-9]+"})
     * @Template()
     *
     * @param Callback $callback
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function editAction(Callback $callback, Request $request)
    {
        $form = $this->createForm(CallbackType::class, $callback);
        $form->add('Save', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $callback = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($callback);
            $em->flush();

            $this->addFlash('success', 'Saved');

            return $this->redirectToRoute('callback_edit', ['id' => $callback->getId()]);
        }

        return ['callback' => $callback, 'callback_form' => $form->createView()];
    }

    /**
     * @Route("/admin/callbacks/delete/{id}", name="callback_delete", requirements={"id": "[0-9]+"})
     * @Template()
     *
     * @param Callback $callback
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Callback $callback)
    {
        $this
            ->getDoctrine()
            ->getRepository('App:Callback')
            ->deleteCallback($callback)
        ;

        return $this->redirectToRoute('callback_list');
    }
}