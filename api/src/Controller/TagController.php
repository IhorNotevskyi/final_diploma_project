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
     */
    public function indexAction()
    {
        $tags = $this
            ->getDoctrine()
            ->getRepository('App:Tag')
            ->findBy([], ['id' => 'DESC'])
        ;

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
     * @return array
     */
    public function editAction(Tag $tag)
    {
        return ['tag' => $tag];
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