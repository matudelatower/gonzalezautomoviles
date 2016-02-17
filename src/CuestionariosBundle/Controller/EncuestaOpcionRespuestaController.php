<?php

namespace CuestionariosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CuestionariosBundle\Entity\EncuestaOpcionRespuesta;
use CuestionariosBundle\Form\EncuestaOpcionRespuestaType;

/**
 * EncuestaOpcionRespuesta controller.
 *
 */
class EncuestaOpcionRespuestaController extends Controller
{

    /**
     * Lists all EncuestaOpcionRespuesta entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CuestionariosBundle:EncuestaOpcionRespuesta')->findAll();

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
        $entities, $request->query->get('page', 1)/* page number */, 10/* limit per page */
        );

        return $this->render('CuestionariosBundle:EncuestaOpcionRespuesta:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new EncuestaOpcionRespuesta entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new EncuestaOpcionRespuesta();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'EncuestaOpcionRespuesta creado correctamente.'
            );

            return $this->redirect($this->generateUrl('encuesta_opcion_respuesta_show', array('id' => $entity->getId())));
        }

        return $this->render('CuestionariosBundle:EncuestaOpcionRespuesta:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a EncuestaOpcionRespuesta entity.
     *
     * @param EncuestaOpcionRespuesta $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(EncuestaOpcionRespuesta $entity)
    {
        $form = $this->createForm(new EncuestaOpcionRespuestaType(), $entity, array(
            'action' => $this->generateUrl('encuesta_opcion_respuesta_create'),
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
     * Displays a form to create a new EncuestaOpcionRespuesta entity.
     *
     */
    public function newAction()
    {
        $entity = new EncuestaOpcionRespuesta();
        $form   = $this->createCreateForm($entity);

        return $this->render('CuestionariosBundle:EncuestaOpcionRespuesta:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a EncuestaOpcionRespuesta entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CuestionariosBundle:EncuestaOpcionRespuesta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EncuestaOpcionRespuesta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CuestionariosBundle:EncuestaOpcionRespuesta:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing EncuestaOpcionRespuesta entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CuestionariosBundle:EncuestaOpcionRespuesta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EncuestaOpcionRespuesta entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CuestionariosBundle:EncuestaOpcionRespuesta:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a EncuestaOpcionRespuesta entity.
    *
    * @param EncuestaOpcionRespuesta $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(EncuestaOpcionRespuesta $entity)
    {
        $form = $this->createForm(new EncuestaOpcionRespuestaType(), $entity, array(
            'action' => $this->generateUrl('encuesta_opcion_respuesta_update', array('id' => $entity->getId())),
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
     * Edits an existing EncuestaOpcionRespuesta entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CuestionariosBundle:EncuestaOpcionRespuesta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EncuestaOpcionRespuesta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'EncuestaOpcionRespuesta actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('encuesta_opcion_respuesta_edit', array('id' => $id)));
        }

        return $this->render('CuestionariosBundle:EncuestaOpcionRespuesta:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a EncuestaOpcionRespuesta entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CuestionariosBundle:EncuestaOpcionRespuesta')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EncuestaOpcionRespuesta entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('encuesta_opcion_respuesta'));
    }

    /**
     * Creates a form to delete a EncuestaOpcionRespuesta entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('encuesta_opcion_respuesta_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
