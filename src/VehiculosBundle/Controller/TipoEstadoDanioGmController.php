<?php

namespace VehiculosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use VehiculosBundle\Entity\TipoEstadoDanioGm;
use VehiculosBundle\Form\TipoEstadoDanioGmType;

/**
 * TipoEstadoDanioGm controller.
 *
 */
class TipoEstadoDanioGmController extends Controller
{

    /**
     * Lists all TipoEstadoDanioGm entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VehiculosBundle:TipoEstadoDanioGm')->findAll();

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
        $entities, $request->query->get('page', 1)/* page number */, 10/* limit per page */
        );

        return $this->render('VehiculosBundle:TipoEstadoDanioGm:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new TipoEstadoDanioGm entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new TipoEstadoDanioGm();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'TipoEstadoDanioGm creado correctamente.'
            );

            return $this->redirect($this->generateUrl('tipo_estado_danio_gm_show', array('id' => $entity->getId())));
        }

        return $this->render('VehiculosBundle:TipoEstadoDanioGm:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a TipoEstadoDanioGm entity.
     *
     * @param TipoEstadoDanioGm $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TipoEstadoDanioGm $entity)
    {
        $form = $this->createForm(new TipoEstadoDanioGmType(), $entity, array(
            'action' => $this->generateUrl('tipo_estado_danio_gm_create'),
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
     * Displays a form to create a new TipoEstadoDanioGm entity.
     *
     */
    public function newAction()
    {
        $entity = new TipoEstadoDanioGm();
        $form   = $this->createCreateForm($entity);

        return $this->render('VehiculosBundle:TipoEstadoDanioGm:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TipoEstadoDanioGm entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:TipoEstadoDanioGm')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoEstadoDanioGm entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:TipoEstadoDanioGm:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TipoEstadoDanioGm entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:TipoEstadoDanioGm')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoEstadoDanioGm entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:TipoEstadoDanioGm:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a TipoEstadoDanioGm entity.
    *
    * @param TipoEstadoDanioGm $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TipoEstadoDanioGm $entity)
    {
        $form = $this->createForm(new TipoEstadoDanioGmType(), $entity, array(
            'action' => $this->generateUrl('tipo_estado_danio_gm_update', array('id' => $entity->getId())),
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
     * Edits an existing TipoEstadoDanioGm entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:TipoEstadoDanioGm')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoEstadoDanioGm entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'TipoEstadoDanioGm actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('tipo_estado_danio_gm_edit', array('id' => $id)));
        }

        return $this->render('VehiculosBundle:TipoEstadoDanioGm:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a TipoEstadoDanioGm entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VehiculosBundle:TipoEstadoDanioGm')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TipoEstadoDanioGm entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tipo_estado_danio_gm'));
    }

    /**
     * Creates a form to delete a TipoEstadoDanioGm entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipo_estado_danio_gm_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
