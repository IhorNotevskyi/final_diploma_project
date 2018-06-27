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
     */
    public function indexAction()
    {
        $callbacks = $this
            ->getDoctrine()
            ->getRepository('App:Callback')
            ->findBy([], ['id' => 'DESC'])
        ;

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
     * @Route("/admin/callbacks/{id}", name="callback_edit", requirements={"id": "[0-9]+"})
     * @Template()
     *
     * @param Callback $callback
     * @return array
     */
    public function editAction(Callback $callback)
    {
        return ['callback' => $callback];
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