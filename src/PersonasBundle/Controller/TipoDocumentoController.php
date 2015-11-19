<?php

namespace PersonasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PersonasBundle\Entity\TipoDocumento;
use PersonasBundle\Form\TipoDocumentoType;

/**
 * TipoDocumento controller.
 *
 */
class TipoDocumentoController extends Controller
{

    /**
     * Lists all TipoDocumento entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PersonasBundle:TipoDocumento')->findAll();

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
        $entities, $request->query->get('page', 1)/* page number */, 10/* limit per page */
        );

        return $this->render('PersonasBundle:TipoDocumento:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new TipoDocumento entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new TipoDocumento();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'TipoDocumento creado correctamente.'
            );

            return $this->redirect($this->generateUrl('tipos_documento_show', array('id' => $entity->getId())));
        }

        return $this->render('PersonasBundle:TipoDocumento:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a TipoDocumento entity.
     *
     * @param TipoDocumento $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TipoDocumento $entity)
    {
        $form = $this->createForm(new TipoDocumentoType(), $entity, array(
            'action' => $this->generateUrl('tipos_documento_create'),
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
     * Displays a form to create a new TipoDocumento entity.
     *
     */
    public function newAction()
    {
        $entity = new TipoDocumento();
        $form   = $this->createCreateForm($entity);

        return $this->render('PersonasBundle:TipoDocumento:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TipoDocumento entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PersonasBundle:TipoDocumento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoDocumento entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PersonasBundle:TipoDocumento:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TipoDocumento entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PersonasBundle:TipoDocumento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoDocumento entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PersonasBundle:TipoDocumento:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a TipoDocumento entity.
    *
    * @param TipoDocumento $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TipoDocumento $entity)
    {
        $form = $this->createForm(new TipoDocumentoType(), $entity, array(
            'action' => $this->generateUrl('tipos_documento_update', array('id' => $entity->getId())),
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
     * Edits an existing TipoDocumento entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PersonasBundle:TipoDocumento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoDocumento entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'TipoDocumento actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('tipos_documento_edit', array('id' => $id)));
        }

        return $this->render('PersonasBundle:TipoDocumento:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a TipoDocumento entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PersonasBundle:TipoDocumento')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TipoDocumento entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tipos_documento'));
    }

    /**
     * Creates a form to delete a TipoDocumento entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipos_documento_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
