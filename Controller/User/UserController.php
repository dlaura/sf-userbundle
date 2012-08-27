<?php

namespace Onfan\UserBundle\Controller\User;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Onfan\UserBundle\Entity\User\User;
use Onfan\UserBundle\Form\User\UserType;

/**
 * User\User controller.
 *
 * @Route("/crud")
 */
class UserController extends Controller
{
    /**
     * Lists all User\User entities.
     *
     * @Route("/", name="crud")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('OnfanUserBundle:User\User')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a User\User entity.
     *
     * @Route("/{id}/show", name="crud_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OnfanUserBundle:User\User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User\User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new User\User entity.
     *
     * @Route("/new", name="crud_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new User();
        $form   = $this->createForm(new UserType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new User\User entity.
     *
     * @Route("/create", name="crud_create")
     * @Method("POST")
     * @Template("OnfanUserBundle:User\User:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new User();
        $form = $this->createForm(new UserType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('crud_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing User\User entity.
     *
     * @Route("/{id}/edit", name="crud_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OnfanUserBundle:User\User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User\User entity.');
        }

        $editForm = $this->createForm(new UserType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing User\User entity.
     *
     * @Route("/{id}/update", name="crud_update")
     * @Method("POST")
     * @Template("OnfanUserBundle:User\User:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OnfanUserBundle:User\User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User\User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new UserType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('crud_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a User\User entity.
     *
     * @Route("/{id}/delete", name="crud_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('OnfanUserBundle:User\User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User\User entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('crud'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
