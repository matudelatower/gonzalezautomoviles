<?php

namespace VehiculosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use VehiculosBundle\Entity\AgendaEntrega;
use VehiculosBundle\Form\AgendaEntregaType;
use UsuariosBundle\Controller\TokenAuthenticatedController;

/**
 * AgendaEntrega controller.
 *
 */
class AgendaEntregaController extends Controller implements TokenAuthenticatedController{

    /**
     * Lists all AgendaEntrega entities.
     *
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VehiculosBundle:AgendaEntrega')->findAll();

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
                $entities, $request->query->get('page', 1)/* page number */, 10/* limit per page */
        );

        return $this->render('VehiculosBundle:AgendaEntrega:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    /**
     * Creates a new AgendaEntrega entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new AgendaEntrega();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                    'success', 'AgendaEntrega creado correctamente.'
            );

            return $this->redirect($this->generateUrl('agenda_entrega_show', array('id' => $entity->getId())));
        }

        return $this->render('VehiculosBundle:AgendaEntrega:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a AgendaEntrega entity.
     *
     * @param AgendaEntrega $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(AgendaEntrega $entity) {
        $form = $this->createForm(new AgendaEntregaType(), $entity, array(
            'action' => $this->generateUrl('agenda_entrega_create'),
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
     * Displays a form to create a new AgendaEntrega entity.
     *
     */
    public function newAction($vehiculoId) {
        $em = $this->getDoctrine()->getManager();
        $vehiculo = $this->getDoctrine()->getManager()->getRepository("VehiculosBundle:Vehiculo")->find($vehiculoId);
        $agendaEntrega = $this->getDoctrine()->getManager()->getRepository("VehiculosBundle:AgendaEntrega")->findOneByVehiculo($vehiculo);
        if (!$agendaEntrega) {
            $agendaEntrega = new AgendaEntrega();
        }
        $agendaEntrega->setVehiculo($vehiculo);
        $form = $this->createForm(new AgendaEntregaType(), $agendaEntrega, array(
            'action' => $this->generateUrl('agenda_entrega_update', array('vehiculoId' => $vehiculoId)),
            'method' => 'POST',
            'attr' => array('class' => 'box-body')
        ));

        $entregas = array();
        $entregas = $em->getRepository('VehiculosBundle:AgendaEntrega')->getEntregasVigentes();

        return $this->render(
                        'VehiculosBundle:AgendaEntrega:new.html.twig', array(
                    'form' => $form->createView(),
                    'vehiculoId' => $vehiculoId,
                    'entregas' => $entregas,
                    'vehiculo' => $vehiculo,
                        )
        );
    }

    /*
     * guarda los datos de la entrega de un vehiculo
     */

    public function AgendaEntregaUpdateAction(Request $request, $vehiculoId) {
        $em = $this->getDoctrine()->getManager();
        $agendaEntrega = $em->getRepository('VehiculosBundle:AgendaEntrega')->findOneByVehiculo($vehiculoId);
        if (!$agendaEntrega) {
            $agendaEntrega = new \VehiculosBundle\Entity\AgendaEntrega();
        }
        $form = $this->createForm(new AgendaEntregaType(), $agendaEntrega, array(
	        'action' => $this->generateUrl('agenda_entrega_update', array('vehiculoId' => $vehiculoId)),
	        'method' => 'POST',
	        'attr' => array('class' => 'box-body')
        ));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($agendaEntrega);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                    'success', 'Agenda actualizada correctamente.'
            );
        } else {
            $this->get('session')->getFlashBag()->add(
                    'error', 'Hubo un error al actualizar la agenda.'
            );
        }


        return $this->redirect($this->generateUrl('agenda_entrega_new', array('vehiculoId' => $vehiculoId)));
    }

    /**
     * Finds and displays a AgendaEntrega entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:AgendaEntrega')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AgendaEntrega entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:AgendaEntrega:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing AgendaEntrega entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:AgendaEntrega')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AgendaEntrega entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:AgendaEntrega:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a AgendaEntrega entity.
     *
     * @param AgendaEntrega $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(AgendaEntrega $entity) {
        $form = $this->createForm(new AgendaEntregaType(), $entity, array(
            'action' => $this->generateUrl('agenda_entrega_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            'attr' => array('class' => 'box-body')
        ));

        $form->add(
                'submit', 'submit', array(
            'label' => 'Actualizar',
            'attr' => array('class' => 'btn btn-primary pull-right'),
                )
        );

        return $form;
    }

    /**
     * Edits an existing AgendaEntrega entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:AgendaEntrega')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AgendaEntrega entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                    'success', 'AgendaEntrega actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('agenda_entrega_edit', array('id' => $id)));
        }

        return $this->render('VehiculosBundle:AgendaEntrega:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a AgendaEntrega entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VehiculosBundle:AgendaEntrega')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AgendaEntrega entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('agenda_entrega'));
    }

    /**
     * Creates a form to delete a AgendaEntrega entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('agenda_entrega_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm();
    }

    public function verMiAgendaAction() {

        $entregas = array();

        //		$usuario = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $entregas = $em->getRepository('VehiculosBundle:AgendaEntrega')->getEntregasVigentes();


        return $this->render('VehiculosBundle:AgendaEntrega:agenda.html.twig', array('entregas' => $entregas));
    }

}
