<?php

namespace VehiculosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use VehiculosBundle\Entity\CheckControlInternoPregunta;
use VehiculosBundle\Form\CheckControlInternoPreguntaType;

/**
 * CheckControlInternoPregunta controller.
 *
 */
class CheckControlInternoPreguntaController extends Controller
{

    /**
     * Lists all CheckControlInternoPregunta entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VehiculosBundle:CheckControlInternoPregunta')->findAll();

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
        $entities, $request->query->get('page', 1)/* page number */, 10/* limit per page */
        );

        return $this->render('VehiculosBundle:CheckControlInternoPregunta:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new CheckControlInternoPregunta entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new CheckControlInternoPregunta();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'CheckControlInternoPregunta creado correctamente.'
            );

            return $this->redirect($this->generateUrl('check_control_interno_pregunta_show', array('id' => $entity->getId())));
        }

        return $this->render('VehiculosBundle:CheckControlInternoPregunta:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a CheckControlInternoPregunta entity.
     *
     * @param CheckControlInternoPregunta $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CheckControlInternoPregunta $entity)
    {
        $form = $this->createForm(new CheckControlInternoPreguntaType(), $entity, array(
            'action' => $this->generateUrl('check_control_interno_pregunta_create'),
            'method' => 'POST',
            'attr' => array('class' => 'box-body')
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Crear',
            'attr' => array('class' => 'btn btn-primary pull-right')
        ));

        return $form;
    }

    /**
     * Displays a form to create a new CheckControlInternoPregunta entity.
     *
     */
    public function newAction()
    {
        $entity = new CheckControlInternoPregunta();
        $form   = $this->createCreateForm($entity);

        return $this->render('VehiculosBundle:CheckControlInternoPregunta:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CheckControlInternoPregunta entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:CheckControlInternoPregunta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CheckControlInternoPregunta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:CheckControlInternoPregunta:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CheckControlInternoPregunta entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:CheckControlInternoPregunta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CheckControlInternoPregunta entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:CheckControlInternoPregunta:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a CheckControlInternoPregunta entity.
    *
    * @param CheckControlInternoPregunta $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(CheckControlInternoPregunta $entity)
    {
        $form = $this->createForm(new CheckControlInternoPreguntaType(), $entity, array(
            'action' => $this->generateUrl('check_control_interno_pregunta_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            'attr' => array('class' => 'box-body')
        ));

        $form->add(
            'submit',
            'submit',
            array(
                'label' => 'Actualizar',
                'attr' => array('class' => 'btn btn-primary pull-right'),
            )
        );

        return $form;
    }
    /**
     * Edits an existing CheckControlInternoPregunta entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:CheckControlInternoPregunta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CheckControlInternoPregunta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'CheckControlInternoPregunta actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('check_control_interno_pregunta_edit', array('id' => $id)));
        }

        return $this->render('VehiculosBundle:CheckControlInternoPregunta:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a CheckControlInternoPregunta entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VehiculosBundle:CheckControlInternoPregunta')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CheckControlInternoPregunta entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('check_control_interno_pregunta'));
    }

    /**
     * Creates a form to delete a CheckControlInternoPregunta entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('check_control_interno_pregunta_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
