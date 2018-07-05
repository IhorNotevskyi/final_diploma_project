<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends Controller
{
    /**
     * @Route("/admin/users", name="user_list")
     * @Template()
     *
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        $queryBuilder = $this
            ->getDoctrine()
            ->getRepository('App:User')
            ->createQueryBuilder('bp')
        ;

        if (
            $request->query->getAlnum('filter_username') ||
            $request->query->getAlnum('filter_email')
        ) {
            $queryBuilder
                ->where('bp.username LIKE :username')
                ->andWhere('bp.email LIKE :email')
                ->setParameter('username', '%' . $request->query->getAlnum('filter_username') . '%')
                ->setParameter('email', '%' . $request->query->getAlnum('filter_email') . '%')
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

        $users = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)
        );

        return ['users' => $users];
    }

    /**
     * @Route("/admin/users/add", name="user_add")
     * @Template()
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function addAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $form = $this->createForm(UserType::class);
        $form->add('Save', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $password = $user->getPassword();
            $encodedPassword = $encoder->encodePassword($user, $password);
            $user->setPassword($encodedPassword);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Saved');

            return $this->redirectToRoute('user_add');
        }

        return ['user_form' => $form->createView()];
    }

    /**
     * @Route("/admin/users/edit/{id}", name="user_edit", requirements={"id": "[0-9]+"})
     * @Template()
     *
     * @param User $user
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function editAction(User $user, Request $request, UserPasswordEncoderInterface $encoder)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->add('Save', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $password = $user->getPassword();
            $encodedPassword = $encoder->encodePassword($user, $password);
            $user->setPassword($encodedPassword);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Saved');

            return $this->redirectToRoute('user_edit', ['id' => $user->getId()]);
        }

        return ['user' => $user, 'user_form' => $form->createView()];
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