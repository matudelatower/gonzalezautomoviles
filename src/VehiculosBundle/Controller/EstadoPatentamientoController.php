<?php

namespace VehiculosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use VehiculosBundle\Entity\EstadoPatentamiento;
use VehiculosBundle\Form\EstadoPatentamientoType;

/**
 * EstadoPatentamiento controller.
 *
 */
class EstadoPatentamientoController extends Controller
{

    /**
     * Lists all EstadoPatentamiento entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VehiculosBundle:EstadoPatentamiento')->findAll();

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
        $entities, $request->query->get('page', 1)/* page number */, 10/* limit per page */
        );

        return $this->render('VehiculosBundle:EstadoPatentamiento:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new EstadoPatentamiento entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new EstadoPatentamiento();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'EstadoPatentamiento creado correctamente.'
            );

            return $this->redirect($this->generateUrl('estado_patentamiento_show', array('id' => $entity->getId())));
        }

        return $this->render('VehiculosBundle:EstadoPatentamiento:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a EstadoPatentamiento entity.
     *
     * @param EstadoPatentamiento $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(EstadoPatentamiento $entity)
    {
        $form = $this->createForm(new EstadoPatentamientoType(), $entity, array(
            'action' => $this->generateUrl('estado_patentamiento_create'),
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
     * Displays a form to create a new EstadoPatentamiento entity.
     *
     */
    public function newAction()
    {
        $entity = new EstadoPatentamiento();
        $form   = $this->createCreateForm($entity);

        return $this->render('VehiculosBundle:EstadoPatentamiento:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a EstadoPatentamiento entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:EstadoPatentamiento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EstadoPatentamiento entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:EstadoPatentamiento:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing EstadoPatentamiento entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:EstadoPatentamiento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EstadoPatentamiento entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:EstadoPatentamiento:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a EstadoPatentamiento entity.
    *
    * @param EstadoPatentamiento $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(EstadoPatentamiento $entity)
    {
        $form = $this->createForm(new EstadoPatentamientoType(), $entity, array(
            'action' => $this->generateUrl('estado_patentamiento_update', array('id' => $entity->getId())),
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
     * Edits an existing EstadoPatentamiento entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:EstadoPatentamiento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EstadoPatentamiento entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'EstadoPatentamiento actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('estado_patentamiento_edit', array('id' => $id)));
        }

        return $this->render('VehiculosBundle:EstadoPatentamiento:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a EstadoPatentamiento entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VehiculosBundle:EstadoPatentamiento')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EstadoPatentamiento entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('estado_patentamiento'));
    }

    /**
     * Creates a form to delete a EstadoPatentamiento entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('estado_patentamiento_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
