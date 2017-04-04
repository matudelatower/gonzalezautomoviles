<?php

namespace CRMBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CRMBundle\Entity\Encuesta;
use CRMBundle\Form\EncuestaType;

/**
 * Encuesta controller.
 *
 */
class EncuestaController extends Controller {

	/**
	 * Lists all Encuesta entities.
	 *
	 */
	public function indexAction( Request $request ) {
		$em = $this->getDoctrine()->getManager();

		$entities = $em->getRepository( 'CRMBundle:Encuesta' )->findAll();

		$paginator = $this->get( 'knp_paginator' );
		$entities  = $paginator->paginate(
			$entities,
			$request->query->get( 'page', 1 )/* page number */,
			10/* limit per page */
		);

		return $this->render( 'CRMBundle:Encuesta:index.html.twig',
			array(
				'entities' => $entities,
			) );
	}

	/**
	 * Creates a new Encuesta entity.
	 *
	 */
	public function createAction( Request $request ) {
		$entity = new Encuesta();
		$form   = $this->createCreateForm( $entity );
		$form->handleRequest( $request );

		if ( $form->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$em->persist( $entity );
			$em->flush();

			$this->get( 'session' )->getFlashBag()->add(
				'success',
				'Encuesta creado correctamente.'
			);

			return $this->redirect( $this->generateUrl( 'crm_encuesta_show', array( 'id' => $entity->getId() ) ) );
		}

		return $this->render( 'CRMBundle:Encuesta:new.html.twig',
			array(
				'entity' => $entity,
				'form'   => $form->createView(),
			) );
	}

	/**
	 * Creates a form to create a Encuesta entity.
	 *
	 * @param Encuesta $entity The entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createCreateForm( Encuesta $entity ) {
		$form = $this->createForm( new EncuestaType(),
			$entity,
			array(
				'action' => $this->generateUrl( 'crm_encuesta_create' ),
				'method' => 'POST',
				'attr'   => array( 'class' => 'box-body' )
			) );

		$form->add( 'submit',
			'submit',
			array(
				'label' => 'Crear',
				'attr'  => array( 'class' => 'btn btn-primary pull-right' )
			) );

		return $form;
	}

	/**
	 * Displays a form to create a new Encuesta entity.
	 *
	 */
	public function newAction() {
		$entity = new Encuesta();
		$form   = $this->createCreateForm( $entity );

		return $this->render( 'CRMBundle:Encuesta:new.html.twig',
			array(
				'entity' => $entity,
				'form'   => $form->createView(),
			) );
	}

	/**
	 * Finds and displays a Encuesta entity.
	 *
	 */
	public function showAction( $id ) {
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository( 'CRMBundle:Encuesta' )->find( $id );

		if ( ! $entity ) {
			throw $this->createNotFoundException( 'Unable to find Encuesta entity.' );
		}

		$deleteForm = $this->createDeleteForm( $id );

		return $this->render( 'CRMBundle:Encuesta:show.html.twig',
			array(
				'entity'      => $entity,
				'delete_form' => $deleteForm->createView(),
			) );
	}

	/**
	 * Displays a form to edit an existing Encuesta entity.
	 *
	 */
	public function editAction( $id ) {
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository( 'CRMBundle:Encuesta' )->find( $id );

		if ( ! $entity ) {
			throw $this->createNotFoundException( 'Unable to find Encuesta entity.' );
		}

		$editForm = $this->createEditForm( $entity );

		return $this->render( 'CRMBundle:Encuesta:edit.html.twig',
			array(
				'entity'    => $entity,
				'edit_form' => $editForm->createView(),
			) );
	}

	/**
	 * Creates a form to edit a Encuesta entity.
	 *
	 * @param Encuesta $entity The entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createEditForm( Encuesta $entity ) {
		$form = $this->createForm( new EncuestaType(),
			$entity,
			array(
				'action' => $this->generateUrl( 'crm_encuesta_update', array( 'id' => $entity->getId() ) ),
				'method' => 'PUT',
				'attr'   => array( 'class' => 'box-body' ),
				'edit'   => true
			) );

		$form->add(
			'submit',
			'submit',
			array(
				'label' => 'Actualizar',
				'attr'  => array( 'class' => 'btn btn-primary pull-right' ),
			)
		);

		return $form;
	}

	/**
	 * Edits an existing Encuesta entity.
	 *
	 */
	public function updateAction( Request $request, $id ) {
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository( 'CRMBundle:Encuesta' )->find( $id );

		if ( ! $entity ) {
			throw $this->createNotFoundException( 'Unable to find Encuesta entity.' );
		}

		$editForm = $this->createEditForm( $entity );
		$editForm->handleRequest( $request );

		if ( $editForm->isValid() ) {

			$em->flush();

			$this->get( 'session' )->getFlashBag()->add(
				'success',
				'Encuesta actualizado correctamente.'
			);

			return $this->redirect( $this->generateUrl( 'crm_encuesta_edit', array( 'id' => $id ) ) );
		}

		return $this->render( 'CRMBundle:Encuesta:edit.html.twig',
			array(
				'entity'    => $entity,
				'edit_form' => $editForm->createView(),
			) );
	}

	/**
	 * Deletes a Encuesta entity.
	 *
	 */
	public function deleteAction( Request $request, $id ) {
		$form = $this->createDeleteForm( $id );
		$form->handleRequest( $request );

		if ( $form->isValid() ) {
			$em     = $this->getDoctrine()->getManager();
			$entity = $em->getRepository( 'CRMBundle:Encuesta' )->find( $id );

			if ( ! $entity ) {
				throw $this->createNotFoundException( 'Unable to find Encuesta entity.' );
			}

			$em->remove( $entity );
			$em->flush();
		}

		return $this->redirect( $this->generateUrl( 'crm_encuesta' ) );
	}

	/**
	 * Creates a form to delete a Encuesta entity by id.
	 *
	 * @param mixed $id The entity id
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm( $id ) {
		return $this->createFormBuilder()
		            ->setAction( $this->generateUrl( 'crm_encuesta_delete', array( 'id' => $id ) ) )
		            ->setMethod( 'DELETE' )
		            ->add( 'submit', 'submit', array( 'label' => 'Delete' ) )
		            ->getForm();
	}
}
