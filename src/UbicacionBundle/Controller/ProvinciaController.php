<?php

namespace UbicacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UsuariosBundle\Controller\TokenAuthenticatedController;
use UbicacionBundle\Entity\Provincia;
use UbicacionBundle\Form\ProvinciaType;

/**
 * Provincia controller.
 *
 */
class ProvinciaController extends Controller implements TokenAuthenticatedController {
    /**
     * Lists all Provincia entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UbicacionBundle:Provincia')->findAll();

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
                $entities, 
                $this->get('request')->query->get('page', 1)/* page number */, 
                10/* limit per page */
        );
        return $this->render('UbicacionBundle:Provincia:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Provincia entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Provincia();
        $form = $this->createForm(new ProvinciaType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                    'success', 'Provincia Creado correctamente.'
            );
            
            return $this->redirect($this->generateUrl('provincia_edit', array('id' => $entity->getId())));
        }

        return $this->render('UbicacionBundle:Provincia:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Provincia entity.
     *
     * @param Provincia $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Provincia $entity)
    {
        $form = $this->createForm(new ProvinciaType(), $entity, array(
            'action' => $this->generateUrl('provincia_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Provincia entity.
     *
     */
    public function newAction()
    {
        $entity = new Provincia();        
        $form   = $this->createForm(new ProvinciaType(), $entity);

        return $this->render('UbicacionBundle:Provincia:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Provincia entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UbicacionBundle:Provincia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Provincia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UbicacionBundle:Provincia:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Provincia entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UbicacionBundle:Provincia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Provincia entity.');
        }
        
        $editForm = $this->createForm(new ProvinciaType(), $entity);
        

        return $this->render('UbicacionBundle:Provincia:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            
        ));
    }

    /**
    * Creates a form to edit a Provincia entity.
    *
    * @param Provincia $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Provincia $entity)
    {
        $form = $this->createForm(new ProvinciaType(), $entity, array(
            'action' => $this->generateUrl('provincia_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Provincia entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UbicacionBundle:Provincia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Provincia entity.');
        }

        
        $editForm =  $this->createForm(new ProvinciaType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                    'success', 'Provincia Actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('provincia_edit', array('id' => $id)));
        }

        return $this->render('UbicacionBundle:Provincia:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            
        ));
    }
    /**
     * Deletes a Provincia entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UbicacionBundle:Provincia')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Provincia entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('provincia'));
    }

    /**
     * Creates a form to delete a Provincia entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('provincia_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
