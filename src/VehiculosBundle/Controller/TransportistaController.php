<?php

namespace VehiculosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use VehiculosBundle\Entity\Transportista;
use VehiculosBundle\Form\TransportistaType;
use UsuariosBundle\Controller\TokenAuthenticatedController;

/**
 * Transportista controller.
 *
 */
class TransportistaController extends Controller implements TokenAuthenticatedController {

    /**
     * Lists all Transportista entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VehiculosBundle:Transportista')->findAll();

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
        $entities, $request->query->get('page', 1)/* page number */, 10/* limit per page */
        );

        return $this->render('VehiculosBundle:Transportista:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Transportista entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Transportista();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'Transportista creado correctamente.'
            );

            return $this->redirect($this->generateUrl('transportistas_show', array('id' => $entity->getId())));
        }

        return $this->render('VehiculosBundle:Transportista:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Transportista entity.
     *
     * @param Transportista $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Transportista $entity)
    {
        $form = $this->createForm(new TransportistaType(), $entity, array(
            'action' => $this->generateUrl('transportistas_create'),
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
     * Displays a form to create a new Transportista entity.
     *
     */
    public function newAction()
    {
        $entity = new Transportista();
        $form   = $this->createCreateForm($entity);

        return $this->render('VehiculosBundle:Transportista:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Transportista entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:Transportista')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Transportista entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:Transportista:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Transportista entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:Transportista')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Transportista entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:Transportista:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Transportista entity.
    *
    * @param Transportista $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Transportista $entity)
    {
        $form = $this->createForm(new TransportistaType(), $entity, array(
            'action' => $this->generateUrl('transportistas_update', array('id' => $entity->getId())),
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
     * Edits an existing Transportista entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:Transportista')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Transportista entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'Transportista actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('transportistas_edit', array('id' => $id)));
        }

        return $this->render('VehiculosBundle:Transportista:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Transportista entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VehiculosBundle:Transportista')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Transportista entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('transportistas'));
    }

    /**
     * Creates a form to delete a Transportista entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('transportistas_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
