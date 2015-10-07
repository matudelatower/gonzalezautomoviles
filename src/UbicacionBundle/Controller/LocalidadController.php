<?php

namespace UbicacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use UbicacionBundle\Entity\Localidad;
use UbicacionBundle\Form\LocalidadType;

/**
 * Localidad controller.
 *
 */
class LocalidadController extends Controller
{

    /**
     * Lists all Localidad entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UbicacionBundle:Localidad')->findAll();

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
                $entities, 
                $this->get('request')->query->get('page', 1)/* page number */, 
                10/* limit per page */
        );
        return $this->render('UbicacionBundle:Localidad:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Localidad entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Localidad();
        $form = $this->createForm(new LocalidadType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                    'success', 'Localidad Creado correctamente.'
            );
            
            return $this->redirect($this->generateUrl('localidad_edit', array('id' => $entity->getId())));
        }

        return $this->render('UbicacionBundle:Localidad:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Localidad entity.
     *
     * @param Localidad $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Localidad $entity)
    {
        $form = $this->createForm(new LocalidadType(), $entity, array(
            'action' => $this->generateUrl('localidad_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Localidad entity.
     *
     */
    public function newAction()
    {
        $entity = new Localidad();        
        $form   = $this->createForm(new LocalidadType(), $entity);

        return $this->render('UbicacionBundle:Localidad:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Localidad entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UbicacionBundle:Localidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Localidad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UbicacionBundle:Localidad:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Localidad entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UbicacionBundle:Localidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Localidad entity.');
        }
        
        $editForm = $this->createForm(new LocalidadType(), $entity);
        

        return $this->render('UbicacionBundle:Localidad:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            
        ));
    }

    /**
    * Creates a form to edit a Localidad entity.
    *
    * @param Localidad $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Localidad $entity)
    {
        $form = $this->createForm(new LocalidadType(), $entity, array(
            'action' => $this->generateUrl('localidad_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Localidad entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UbicacionBundle:Localidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Localidad entity.');
        }

        
        $editForm =  $this->createForm(new LocalidadType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                    'success', 'Localidad Actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('localidad_edit', array('id' => $id)));
        }

        return $this->render('UbicacionBundle:Localidad:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            
        ));
    }
    /**
     * Deletes a Localidad entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UbicacionBundle:Localidad')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Localidad entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('localidad'));
    }

    /**
     * Creates a form to delete a Localidad entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('localidad_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
