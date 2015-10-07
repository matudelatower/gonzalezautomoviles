<?php

namespace UbicacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use UbicacionBundle\Entity\Departamento;
use UbicacionBundle\Form\DepartamentoType;

/**
 * Departamento controller.
 *
 */
class DepartamentoController extends Controller
{

    /**
     * Lists all Departamento entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UbicacionBundle:Departamento')->findAll();

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
                $entities, 
                $this->get('request')->query->get('page', 1)/* page number */, 
                10/* limit per page */
        );
        return $this->render('UbicacionBundle:Departamento:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Departamento entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Departamento();
        $form = $this->createForm(new DepartamentoType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                    'success', 'Departamento Creado correctamente.'
            );
            
            return $this->redirect($this->generateUrl('departamento_edit', array('id' => $entity->getId())));
        }

        return $this->render('UbicacionBundle:Departamento:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Departamento entity.
     *
     * @param Departamento $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Departamento $entity)
    {
        $form = $this->createForm(new DepartamentoType(), $entity, array(
            'action' => $this->generateUrl('departamento_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Departamento entity.
     *
     */
    public function newAction()
    {
        $entity = new Departamento();        
        $form   = $this->createForm(new DepartamentoType(), $entity);

        return $this->render('UbicacionBundle:Departamento:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Departamento entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UbicacionBundle:Departamento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Departamento entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UbicacionBundle:Departamento:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Departamento entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UbicacionBundle:Departamento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Departamento entity.');
        }
        
        $editForm = $this->createForm(new DepartamentoType(), $entity);
        

        return $this->render('UbicacionBundle:Departamento:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            
        ));
    }

    /**
    * Creates a form to edit a Departamento entity.
    *
    * @param Departamento $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Departamento $entity)
    {
        $form = $this->createForm(new DepartamentoType(), $entity, array(
            'action' => $this->generateUrl('departamento_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Departamento entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UbicacionBundle:Departamento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Departamento entity.');
        }

        
        $editForm =  $this->createForm(new DepartamentoType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                    'success', 'Departamento Actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('departamento_edit', array('id' => $id)));
        }

        return $this->render('UbicacionBundle:Departamento:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            
        ));
    }
    /**
     * Deletes a Departamento entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UbicacionBundle:Departamento')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Departamento entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('departamento'));
    }

    /**
     * Creates a form to delete a Departamento entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('departamento_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
