<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Security\UserVoter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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

        $totalPages = ceil($users->getTotalItemCount() / $users->getItemNumberPerPage());
        if ($request->query->get('page') > $totalPages) {
            throw $this->createNotFoundException('The requested page was not found');
        }

        return ['users' => $users];
    }

    /**
     * @Route("/admin/users/add", name="user_add")
     * @Template()
     *
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param \Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function addAction(Request $request, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(UserType::class);
        $form->add('Save', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $message = (new \Swift_Message('You have been added to the list of administrators'))
                ->setFrom($this->getParameter('swiftmailer.sender_address'))
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'mail_message.html.twig', [
                            'name' => $user->getUsername(),
                            'password' => $user->getPassword()
                        ]
                    ),
                    'text/html'
                )
            ;

            $password = $user->getPassword();
            $encodedPassword = $encoder->encodePassword($user, $password);
            $user->setPassword($encodedPassword);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $mailer->send($message);

            $this->addFlash('success', 'Saved');

            return $this->redirectToRoute('user_add');
        }

        return ['user_form' => $form->createView()];
    }

    /**
     * @Route("/admin/users/edit/{id}", name="user_edit", requirements={"id": "[0-9]+"})
     * @Template()
     *
     * @param $id
     * @param User $user
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function editAction($id, User $user, Request $request, UserPasswordEncoderInterface $encoder)
    {
        $admin = $this
            ->getDoctrine()
            ->getRepository('App:User')
            ->find($id)
        ;

        $this->denyAccessUnlessGranted(UserVoter::EDIT, $admin);

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
     * @Security("has_role('ROLE_ADMIN')")
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