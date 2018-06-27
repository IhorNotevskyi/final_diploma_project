<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @Route("/admin/users", name="user_list")
     * @Template()
     */
    public function indexAction()
    {
        $users = $this
            ->getDoctrine()
            ->getRepository('App:User')
            ->findBy([], ['id' => 'DESC'])
        ;

        return ['users' => $users];
    }

    /**
     * @Route("/admin/users/add", name="user_add")
     * @Template()
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function addAction(Request $request)
    {
        $form = $this->createForm(UserType::class);
        $form->add('Save', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Saved');

            return $this->redirectToRoute('user_add');
        }

        return ['user_form' => $form->createView()];
    }

    /**
     * @Route("/admin/users/{id}", name="user_edit", requirements={"id": "[0-9]+"})
     * @Template()
     *
     * @param User $user
     * @return array
     */
    public function editAction(User $user)
    {
        return ['user' => $user];
    }

    /**
     * @Route("/admin/users/delete/{id}", name="user_delete", requirements={"id": "[0-9]+"})
     * @Template()
     *
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(User $user)
    {
        $this
            ->getDoctrine()
            ->getRepository('App:User')
            ->deleteUser($user)
        ;

        return $this->redirectToRoute('user_list');
    }
}