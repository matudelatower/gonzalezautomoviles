<?php

namespace VehiculosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use VehiculosBundle\Entity\MovimientoDeposito;
use VehiculosBundle\Form\MovimientoDepositoType;

/**
 * MovimientoDeposito controller.
 *
 */
class MovimientoDepositoController extends Controller
{

    /**
     * Lists all MovimientoDeposito entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VehiculosBundle:MovimientoDeposito')->findAll();

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
        $entities, $request->query->get('page', 1)/* page number */, 10/* limit per page */
        );

        return $this->render('VehiculosBundle:MovimientoDeposito:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new MovimientoDeposito entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new MovimientoDeposito();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'MovimientoDeposito creado correctamente.'
            );

            return $this->redirect($this->generateUrl('movimiento_deposito_show', array('id' => $entity->getId())));
        }

        return $this->render('VehiculosBundle:MovimientoDeposito:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a MovimientoDeposito entity.
     *
     * @param MovimientoDeposito $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(MovimientoDeposito $entity)
    {
        $form = $this->createForm(new MovimientoDepositoType(), $entity, array(
            'action' => $this->generateUrl('movimiento_deposito_create'),
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
     * Displays a form to create a new MovimientoDeposito entity.
     *
     */
    public function newAction()
    {
        $entity = new MovimientoDeposito();
        $form   = $this->createCreateForm($entity);

        return $this->render('VehiculosBundle:MovimientoDeposito:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a MovimientoDeposito entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:MovimientoDeposito')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MovimientoDeposito entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:MovimientoDeposito:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing MovimientoDeposito entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:MovimientoDeposito')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MovimientoDeposito entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:MovimientoDeposito:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a MovimientoDeposito entity.
    *
    * @param MovimientoDeposito $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(MovimientoDeposito $entity)
    {
        $form = $this->createForm(new MovimientoDepositoType(), $entity, array(
            'action' => $this->generateUrl('movimiento_deposito_update', array('id' => $entity->getId())),
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
     * Edits an existing MovimientoDeposito entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:MovimientoDeposito')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MovimientoDeposito entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'MovimientoDeposito actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('movimiento_deposito_edit', array('id' => $id)));
        }

        return $this->render('VehiculosBundle:MovimientoDeposito:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a MovimientoDeposito entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VehiculosBundle:MovimientoDeposito')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MovimientoDeposito entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('movimiento_deposito'));
    }

    /**
     * Creates a form to delete a MovimientoDeposito entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('movimiento_deposito_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
