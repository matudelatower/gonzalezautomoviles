<?php

namespace VehiculosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use VehiculosBundle\Entity\TipoMovimiento;
use VehiculosBundle\Form\TipoMovimientoType;

/**
 * TipoMovimiento controller.
 *
 */
class TipoMovimientoController extends Controller
{

    /**
     * Lists all TipoMovimiento entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VehiculosBundle:TipoMovimiento')->findAll();

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
        $entities, $request->query->get('page', 1)/* page number */, 10/* limit per page */
        );

        return $this->render('VehiculosBundle:TipoMovimiento:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new TipoMovimiento entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new TipoMovimiento();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'TipoMovimiento creado correctamente.'
            );

            return $this->redirect($this->generateUrl('tipo_movimiento_show', array('id' => $entity->getId())));
        }

        return $this->render('VehiculosBundle:TipoMovimiento:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a TipoMovimiento entity.
     *
     * @param TipoMovimiento $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TipoMovimiento $entity)
    {
        $form = $this->createForm(new TipoMovimientoType(), $entity, array(
            'action' => $this->generateUrl('tipo_movimiento_create'),
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
     * Displays a form to create a new TipoMovimiento entity.
     *
     */
    public function newAction()
    {
        $entity = new TipoMovimiento();
        $form   = $this->createCreateForm($entity);

        return $this->render('VehiculosBundle:TipoMovimiento:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TipoMovimiento entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:TipoMovimiento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoMovimiento entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:TipoMovimiento:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TipoMovimiento entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:TipoMovimiento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoMovimiento entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:TipoMovimiento:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a TipoMovimiento entity.
    *
    * @param TipoMovimiento $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TipoMovimiento $entity)
    {
        $form = $this->createForm(new TipoMovimientoType(), $entity, array(
            'action' => $this->generateUrl('tipo_movimiento_update', array('id' => $entity->getId())),
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
     * Edits an existing TipoMovimiento entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:TipoMovimiento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoMovimiento entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'TipoMovimiento actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('tipo_movimiento_edit', array('id' => $id)));
        }

        return $this->render('VehiculosBundle:TipoMovimiento:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a TipoMovimiento entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VehiculosBundle:TipoMovimiento')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TipoMovimiento entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tipo_movimiento'));
    }

    /**
     * Creates a form to delete a TipoMovimiento entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipo_movimiento_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
