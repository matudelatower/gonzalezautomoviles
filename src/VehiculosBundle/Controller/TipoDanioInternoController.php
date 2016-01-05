<?php

namespace VehiculosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use VehiculosBundle\Entity\TipoDanioInterno;
use VehiculosBundle\Form\TipoDanioInternoType;

/**
 * TipoDanioInterno controller.
 *
 */
class TipoDanioInternoController extends Controller
{

    /**
     * Lists all TipoDanioInterno entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VehiculosBundle:TipoDanioInterno')->findAll();

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
        $entities, $request->query->get('page', 1)/* page number */, 10/* limit per page */
        );

        return $this->render('VehiculosBundle:TipoDanioInterno:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new TipoDanioInterno entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new TipoDanioInterno();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'TipoDanioInterno creado correctamente.'
            );

            return $this->redirect($this->generateUrl('tipo_danio_interno_show', array('id' => $entity->getId())));
        }

        return $this->render('VehiculosBundle:TipoDanioInterno:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a TipoDanioInterno entity.
     *
     * @param TipoDanioInterno $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TipoDanioInterno $entity)
    {
        $form = $this->createForm(new TipoDanioInternoType(), $entity, array(
            'action' => $this->generateUrl('tipo_danio_interno_create'),
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
     * Displays a form to create a new TipoDanioInterno entity.
     *
     */
    public function newAction()
    {
        $entity = new TipoDanioInterno();
        $form   = $this->createCreateForm($entity);

        return $this->render('VehiculosBundle:TipoDanioInterno:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TipoDanioInterno entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:TipoDanioInterno')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoDanioInterno entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:TipoDanioInterno:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TipoDanioInterno entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:TipoDanioInterno')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoDanioInterno entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:TipoDanioInterno:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a TipoDanioInterno entity.
    *
    * @param TipoDanioInterno $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TipoDanioInterno $entity)
    {
        $form = $this->createForm(new TipoDanioInternoType(), $entity, array(
            'action' => $this->generateUrl('tipo_danio_interno_update', array('id' => $entity->getId())),
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
     * Edits an existing TipoDanioInterno entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:TipoDanioInterno')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoDanioInterno entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'TipoDanioInterno actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('tipo_danio_interno_edit', array('id' => $id)));
        }

        return $this->render('VehiculosBundle:TipoDanioInterno:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a TipoDanioInterno entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VehiculosBundle:TipoDanioInterno')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TipoDanioInterno entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tipo_danio_interno'));
    }

    /**
     * Creates a form to delete a TipoDanioInterno entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipo_danio_interno_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
