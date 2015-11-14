<?php

namespace VehiculosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use VehiculosBundle\Entity\CheckControlInterno;
use VehiculosBundle\Form\CheckControlInternoType;

/**
 * CheckControlInterno controller.
 *
 */
class CheckControlInternoController extends Controller
{

    /**
     * Lists all CheckControlInterno entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VehiculosBundle:CheckControlInterno')->findAll();

        return $this->render(
            'VehiculosBundle:CheckControlInterno:index.html.twig',
            array(
                'entities' => $entities,
            )
        );
    }

    /**
     * Creates a new CheckControlInterno entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new CheckControlInterno();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                'CheckControlInterno creado correctamente.'
            );

            return $this->redirect($this->generateUrl('check_control_interno_show', array('id' => $entity->getId())));
        }

        return $this->render(
            'VehiculosBundle:CheckControlInterno:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Creates a form to create a CheckControlInterno entity.
     *
     * @param CheckControlInterno $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CheckControlInterno $entity)
    {
        $form = $this->createForm(
            new CheckControlInternoType(),
            $entity,
            array(
                'action' => $this->generateUrl('check_control_interno_create'),
                'method' => 'POST',
                'attr' => array('class' => 'box-body')
            )
        );

        $form->add(
            'submit',
            'submit',
            array(
                'label' => 'Crear',
                'attr' => array('class' => 'btn btn-primary pull-right')
            )
        );

        return $form;
    }

    /**
     * Displays a form to create a new CheckControlInterno entity.
     *
     */
    public function newAction($vehiculoId)
    {
        $entity = new CheckControlInterno();
        $em = $this->getDoctrine()->getManager();
        $vehiculo = $em->getRepository('VehiculosBundle:Vehiculo')->find($vehiculoId);
        $entity->setVehiculo($vehiculo);
        $form = $this->createCreateForm($entity);

        return $this->render(
            'VehiculosBundle:CheckControlInterno:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a CheckControlInterno entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:CheckControlInterno')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CheckControlInterno entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'VehiculosBundle:CheckControlInterno:show.html.twig',
            array(
                'entity' => $entity,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing CheckControlInterno entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:CheckControlInterno')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CheckControlInterno entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'VehiculosBundle:CheckControlInterno:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to edit a CheckControlInterno entity.
     *
     * @param CheckControlInterno $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(CheckControlInterno $entity)
    {
        $form = $this->createForm(
            new CheckControlInternoType(),
            $entity,
            array(
                'action' => $this->generateUrl('check_control_interno_update', array('id' => $entity->getId())),
                'method' => 'PUT',
                'attr' => array('class' => 'box-body')
            )
        );

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
     * Edits an existing CheckControlInterno entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:CheckControlInterno')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CheckControlInterno entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                'CheckControlInterno actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('check_control_interno_edit', array('id' => $id)));
        }

        return $this->render(
            'VehiculosBundle:CheckControlInterno:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a CheckControlInterno entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VehiculosBundle:CheckControlInterno')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CheckControlInterno entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('check_control_interno'));
    }

    /**
     * Creates a form to delete a CheckControlInterno entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('check_control_interno_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
