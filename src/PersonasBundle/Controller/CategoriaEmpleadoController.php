<?php

namespace PersonasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UsuariosBundle\Controller\TokenAuthenticatedController;
use PersonasBundle\Entity\CategoriaEmpleado;
use PersonasBundle\Form\CategoriaEmpleadoType;

/**
 * CategoriaEmpleado controller.
 *
 */
class CategoriaEmpleadoController extends Controller implements TokenAuthenticatedController{

    /**
     * Lists all CategoriaEmpleado entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PersonasBundle:CategoriaEmpleado')->findAll();

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
        $entities, $request->query->get('page', 1)/* page number */, 10/* limit per page */
        );

        return $this->render('PersonasBundle:CategoriaEmpleado:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new CategoriaEmpleado entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new CategoriaEmpleado();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'CategoriaEmpleado creado correctamente.'
            );

            return $this->redirect($this->generateUrl('categoria_empleado_show', array('id' => $entity->getId())));
        }

        return $this->render('PersonasBundle:CategoriaEmpleado:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a CategoriaEmpleado entity.
     *
     * @param CategoriaEmpleado $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CategoriaEmpleado $entity)
    {
        $form = $this->createForm(new CategoriaEmpleadoType(), $entity, array(
            'action' => $this->generateUrl('categoria_empleado_create'),
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
     * Displays a form to create a new CategoriaEmpleado entity.
     *
     */
    public function newAction()
    {
        $entity = new CategoriaEmpleado();
        $form   = $this->createCreateForm($entity);

        return $this->render('PersonasBundle:CategoriaEmpleado:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CategoriaEmpleado entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PersonasBundle:CategoriaEmpleado')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CategoriaEmpleado entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PersonasBundle:CategoriaEmpleado:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CategoriaEmpleado entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PersonasBundle:CategoriaEmpleado')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CategoriaEmpleado entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PersonasBundle:CategoriaEmpleado:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a CategoriaEmpleado entity.
    *
    * @param CategoriaEmpleado $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(CategoriaEmpleado $entity)
    {
        $form = $this->createForm(new CategoriaEmpleadoType(), $entity, array(
            'action' => $this->generateUrl('categoria_empleado_update', array('id' => $entity->getId())),
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
     * Edits an existing CategoriaEmpleado entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PersonasBundle:CategoriaEmpleado')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CategoriaEmpleado entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'CategoriaEmpleado actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('categoria_empleado_edit', array('id' => $id)));
        }

        return $this->render('PersonasBundle:CategoriaEmpleado:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a CategoriaEmpleado entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PersonasBundle:CategoriaEmpleado')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CategoriaEmpleado entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('categoria_empleado'));
    }

    /**
     * Creates a form to delete a CategoriaEmpleado entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('categoria_empleado_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
