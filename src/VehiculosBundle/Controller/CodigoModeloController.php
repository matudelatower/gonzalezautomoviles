<?php

namespace VehiculosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use VehiculosBundle\Entity\CodigoModelo;
use VehiculosBundle\Form\CodigoModeloType;
use VehiculosBundle\Form\Filter\CodigoModeloFilterType;
use UsuariosBundle\Controller\TokenAuthenticatedController;

/**
 * CodigoModelo controller.
 *
 */
class CodigoModeloController extends Controller implements TokenAuthenticatedController {

    /**
     * Lists all CodigoModelo entities.
     *
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new CodigoModeloFilterType());

        if ($request->isMethod("post")) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $entities = $em->getRepository('VehiculosBundle:CodigoModelo')->getCodigosModelosFilter($data);
            }
        } else {
            $entities = $em->getRepository('VehiculosBundle:CodigoModelo')->getCodigosModelosFilter();
        }
        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
                $entities, $request->query->get('page', 1)/* page number */, 10/* limit per page */
        );
        
        return $this->render('VehiculosBundle:CodigoModelo:index.html.twig', array(
        'entities' => $entities,
        'form'=>$form->createView()
        ));
    }

    /**
     * Creates a new CodigoModelo entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new CodigoModelo();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                    'success', 'CodigoModelo creado correctamente.'
            );

            $parameter = array();

            if ($form->get('sumbitNew')->isClicked()) {
                $ruta = 'codigo_modelo_new';
            } else {
                $ruta = 'codigo_modelo_show';
                $parameter = array('id' => $entity->getId());
            }


            return $this->redirectToRoute($ruta, $parameter);

//            return $this->redirect();
        }

        return $this->render('VehiculosBundle:CodigoModelo:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a CodigoModelo entity.
     *
     * @param CodigoModelo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CodigoModelo $entity) {
        $form = $this->createForm(new CodigoModeloType(), $entity, array(
            'action' => $this->generateUrl('codigo_modelo_create'),
            'method' => 'POST',
            'attr' => array('class' => 'box-body')
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Crear',
            'attr' => array('class' => 'btn btn-primary pull-right')
        ));

        $form->add('sumbitNew', 'submit', array(
            'label' => 'Crear y Agregar',
            'attr' => array('class' => 'btn btn-success pull-right')
        ));

        return $form;
    }

    /**
     * Displays a form to create a new CodigoModelo entity.
     *
     */
    public function newAction() {
        $entity = new CodigoModelo();
        $form = $this->createCreateForm($entity);

        return $this->render('VehiculosBundle:CodigoModelo:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CodigoModelo entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:CodigoModelo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CodigoModelo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:CodigoModelo:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CodigoModelo entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:CodigoModelo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CodigoModelo entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:CodigoModelo:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a CodigoModelo entity.
     *
     * @param CodigoModelo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(CodigoModelo $entity) {
        $form = $this->createForm(new CodigoModeloType(), $entity, array(
            'action' => $this->generateUrl('codigo_modelo_update', array('id' => $entity->getId())),
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
     * Edits an existing CodigoModelo entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:CodigoModelo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CodigoModelo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                    'success', 'CodigoModelo actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('codigo_modelo_edit', array('id' => $id)));
        }

        return $this->render('VehiculosBundle:CodigoModelo:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a CodigoModelo entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VehiculosBundle:CodigoModelo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CodigoModelo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('codigo_modelo'));
    }

    /**
     * Creates a form to delete a CodigoModelo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('codigo_modelo_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm();
    }

}
