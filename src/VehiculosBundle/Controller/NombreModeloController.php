<?php

namespace VehiculosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use VehiculosBundle\Entity\NombreModelo;
use VehiculosBundle\Form\NombreModeloType;

/**
 * NombreModelo controller.
 *
 */
class NombreModeloController extends Controller
{

    /**
     * Lists all NombreModelo entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VehiculosBundle:NombreModelo')->findAll();

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
        $entities, $this->get('request')->query->get('page', 1)/* page number */, 10/* limit per page */
        );

        return $this->render('VehiculosBundle:NombreModelo:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new NombreModelo entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new NombreModelo();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'NombreModelo creado correctamente.'
            );

            return $this->redirect($this->generateUrl('nombre_modelo_show', array('id' => $entity->getId())));
        }

        return $this->render('VehiculosBundle:NombreModelo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a NombreModelo entity.
     *
     * @param NombreModelo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(NombreModelo $entity)
    {
        $form = $this->createForm(new NombreModeloType(), $entity, array(
            'action' => $this->generateUrl('nombre_modelo_create'),
            'method' => 'POST',
            'attr' => array('class' => 'box-body')
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Crear',
            'attr' => array('class' => 'btn btn-primary pull-right')
        ));

        $form->add('sumbitNew', 'submit', array(
            'label' => 'Crear y Agregar',
            'attr' => array('class' => 'btn btn-success pull-right')
        ));


        return $form;
    }

    /**
     * Displays a form to create a new NombreModelo entity.
     *
     */
    public function newAction()
    {
        $entity = new NombreModelo();
        $form   = $this->createCreateForm($entity);

        return $this->render('VehiculosBundle:NombreModelo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a NombreModelo entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:NombreModelo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NombreModelo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:NombreModelo:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing NombreModelo entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:NombreModelo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NombreModelo entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:NombreModelo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a NombreModelo entity.
    *
    * @param NombreModelo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(NombreModelo $entity)
    {
        $form = $this->createForm(new NombreModeloType(), $entity, array(
            'action' => $this->generateUrl('nombre_modelo_update', array('id' => $entity->getId())),
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
     * Edits an existing NombreModelo entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:NombreModelo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NombreModelo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'NombreModelo actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('nombre_modelo_edit', array('id' => $id)));
        }

        return $this->render('VehiculosBundle:NombreModelo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a NombreModelo entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VehiculosBundle:NombreModelo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find NombreModelo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('nombre_modelo'));
    }

    /**
     * Creates a form to delete a NombreModelo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('nombre_modelo_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
