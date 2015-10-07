<?php

namespace VehiculosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use VehiculosBundle\Entity\TipoEstadoVehiculo;
use VehiculosBundle\Form\TipoEstadoVehiculoType;

/**
 * TipoEstadoVehiculo controller.
 *
 */
class TipoEstadoVehiculoController extends Controller
{

    /**
     * Lists all TipoEstadoVehiculo entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VehiculosBundle:TipoEstadoVehiculo')->findAll();

        return $this->render('VehiculosBundle:TipoEstadoVehiculo:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new TipoEstadoVehiculo entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new TipoEstadoVehiculo();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'TipoEstadoVehiculo creado correctamente.'
            );

            return $this->redirect($this->generateUrl('tipo_estado_vehiculo_show', array('id' => $entity->getId())));
        }

        return $this->render('VehiculosBundle:TipoEstadoVehiculo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a TipoEstadoVehiculo entity.
     *
     * @param TipoEstadoVehiculo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TipoEstadoVehiculo $entity)
    {
        $form = $this->createForm(new TipoEstadoVehiculoType(), $entity, array(
            'action' => $this->generateUrl('tipo_estado_vehiculo_create'),
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
     * Displays a form to create a new TipoEstadoVehiculo entity.
     *
     */
    public function newAction()
    {
        $entity = new TipoEstadoVehiculo();
        $form   = $this->createCreateForm($entity);

        return $this->render('VehiculosBundle:TipoEstadoVehiculo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TipoEstadoVehiculo entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:TipoEstadoVehiculo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoEstadoVehiculo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:TipoEstadoVehiculo:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TipoEstadoVehiculo entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:TipoEstadoVehiculo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoEstadoVehiculo entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:TipoEstadoVehiculo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a TipoEstadoVehiculo entity.
    *
    * @param TipoEstadoVehiculo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TipoEstadoVehiculo $entity)
    {
        $form = $this->createForm(new TipoEstadoVehiculoType(), $entity, array(
            'action' => $this->generateUrl('tipo_estado_vehiculo_update', array('id' => $entity->getId())),
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
     * Edits an existing TipoEstadoVehiculo entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:TipoEstadoVehiculo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoEstadoVehiculo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'TipoEstadoVehiculo actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('tipo_estado_vehiculo_edit', array('id' => $id)));
        }

        return $this->render('VehiculosBundle:TipoEstadoVehiculo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a TipoEstadoVehiculo entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VehiculosBundle:TipoEstadoVehiculo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TipoEstadoVehiculo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tipo_estado_vehiculo'));
    }

    /**
     * Creates a form to delete a TipoEstadoVehiculo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipo_estado_vehiculo_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
