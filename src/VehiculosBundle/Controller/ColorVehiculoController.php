<?php

namespace VehiculosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use VehiculosBundle\Entity\ColorVehiculo;
use VehiculosBundle\Form\ColorVehiculoType;

/**
 * ColorVehiculo controller.
 *
 */
class ColorVehiculoController extends Controller
{

    /**
     * Lists all ColorVehiculo entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VehiculosBundle:ColorVehiculo')->findAll();

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
        $entities, $request->query->get('page', 1)/* page number */, 10/* limit per page */
        );

        return $this->render('VehiculosBundle:ColorVehiculo:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new ColorVehiculo entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ColorVehiculo();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'ColorVehiculo creado correctamente.'
            );

            return $this->redirect($this->generateUrl('color_vehiculo_show', array('id' => $entity->getId())));
        }

        return $this->render('VehiculosBundle:ColorVehiculo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ColorVehiculo entity.
     *
     * @param ColorVehiculo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ColorVehiculo $entity)
    {
        $form = $this->createForm(new ColorVehiculoType(), $entity, array(
            'action' => $this->generateUrl('color_vehiculo_create'),
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
     * Displays a form to create a new ColorVehiculo entity.
     *
     */
    public function newAction()
    {
        $entity = new ColorVehiculo();
        $form   = $this->createCreateForm($entity);

        return $this->render('VehiculosBundle:ColorVehiculo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ColorVehiculo entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:ColorVehiculo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ColorVehiculo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:ColorVehiculo:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ColorVehiculo entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:ColorVehiculo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ColorVehiculo entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:ColorVehiculo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a ColorVehiculo entity.
    *
    * @param ColorVehiculo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ColorVehiculo $entity)
    {
        $form = $this->createForm(new ColorVehiculoType(), $entity, array(
            'action' => $this->generateUrl('color_vehiculo_update', array('id' => $entity->getId())),
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
     * Edits an existing ColorVehiculo entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:ColorVehiculo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ColorVehiculo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'ColorVehiculo actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('color_vehiculo_edit', array('id' => $id)));
        }

        return $this->render('VehiculosBundle:ColorVehiculo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a ColorVehiculo entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VehiculosBundle:ColorVehiculo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ColorVehiculo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('color_vehiculo'));
    }

    /**
     * Creates a form to delete a ColorVehiculo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('color_vehiculo_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
