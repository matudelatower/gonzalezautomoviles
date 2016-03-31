<?php

namespace UsuariosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use UsuariosBundle\Entity\PermisoEspecial;
use UsuariosBundle\Form\PermisoEspecialType;

/**
 * PermisoEspecial controller.
 *
 */
class PermisoEspecialController extends Controller {

	/**
	 * Lists all PermisoEspecial entities.
	 *
	 */
	public function indexAction( Request $request ) {
		$em = $this->getDoctrine()->getManager();

		$entities = $em->getRepository( 'UsuariosBundle:PermisoEspecial' )->findAll();

		$paginator = $this->get( 'knp_paginator' );
		$entities  = $paginator->paginate(
			$entities,
			$request->query->get( 'page', 1 )/* page number */,
			10/* limit per page */
		);

		return $this->render( 'UsuariosBundle:PermisoEspecial:index.html.twig',
			array(
				'entities' => $entities,
			) );
	}

	/**
	 * Creates a new PermisoEspecial entity.
	 *
	 */
	public function createAction( Request $request ) {
		$entity = new PermisoEspecial();
		$form   = $this->createCreateForm( $entity );
		$form->handleRequest( $request );

		if ( $form->isValid() ) {

			$controller = $entity->getController();
			$pos        = strrpos( $controller, ":" );
			$id         = $pos === false ? $controller : substr( $controller, $pos + 1 );
			$entity->setController( substr( $controller, 0, $pos ) );
			$entity->setAction( $id );
			$em = $this->getDoctrine()->getManager();
			$em->persist( $entity );
			$em->flush();

			$this->get( 'session' )->getFlashBag()->add(
				'success',
				'PermisoEspecial creado correctamente.'
			);

			return $this->redirect( $this->generateUrl( 'permiso_especial_show', array( 'id' => $entity->getId() ) ) );
		}

		return $this->render( 'UsuariosBundle:PermisoEspecial:new.html.twig',
			array(
				'entity' => $entity,
				'form'   => $form->createView(),
			) );
	}

	/**
	 * Creates a form to create a PermisoEspecial entity.
	 *
	 * @param PermisoEspecial $entity The entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createCreateForm( PermisoEspecial $entity ) {
		$form = $this->createForm( new PermisoEspecialType( $this->get( 'manager.app' ) ),
			$entity,
			array(
				'action' => $this->generateUrl( 'permiso_especial_create' ),
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
	 * Displays a form to create a new PermisoEspecial entity.
	 *
	 */
	public function newAction() {
		$entity = new PermisoEspecial();
		$form   = $this->createCreateForm( $entity );

		return $this->render( 'UsuariosBundle:PermisoEspecial:new.html.twig',
			array(
				'entity' => $entity,
				'form'   => $form->createView(),
			) );
	}

	/**
	 * Finds and displays a PermisoEspecial entity.
	 *
	 */
	public function showAction( $id ) {
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository( 'UsuariosBundle:PermisoEspecial' )->find( $id );

		if ( ! $entity ) {
			throw $this->createNotFoundException( 'Unable to find PermisoEspecial entity.' );
		}

		$deleteForm = $this->createDeleteForm( $id );

		return $this->render( 'UsuariosBundle:PermisoEspecial:show.html.twig',
			array(
				'entity'      => $entity,
				'delete_form' => $deleteForm->createView(),
			) );
	}

	/**
	 * Displays a form to edit an existing PermisoEspecial entity.
	 *
	 */
	public function editAction( $id ) {
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository( 'UsuariosBundle:PermisoEspecial' )->find( $id );

		if ( ! $entity ) {
			throw $this->createNotFoundException( 'Unable to find PermisoEspecial entity.' );
		}

		$editForm   = $this->createEditForm( $entity );
		$deleteForm = $this->createDeleteForm( $id );

		return $this->render( 'UsuariosBundle:PermisoEspecial:edit.html.twig',
			array(
				'entity'      => $entity,
				'edit_form'   => $editForm->createView(),
				'delete_form' => $deleteForm->createView(),
			) );
	}

	/**
	 * Creates a form to edit a PermisoEspecial entity.
	 *
	 * @param PermisoEspecial $entity The entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createEditForm( PermisoEspecial $entity ) {
		$form = $this->createForm( new PermisoEspecialType( $this->get( 'manager.app' ) ),
			$entity,
			array(
				'action' => $this->generateUrl( 'permiso_especial_update', array( 'id' => $entity->getId() ) ),
				'method' => 'PUT',
				'attr'   => array( 'class' => 'box-body' )
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
	 * Edits an existing PermisoEspecial entity.
	 *
	 */
	public function updateAction( Request $request, $id ) {
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository( 'UsuariosBundle:PermisoEspecial' )->find( $id );

		if ( ! $entity ) {
			throw $this->createNotFoundException( 'Unable to find PermisoEspecial entity.' );
		}

		$deleteForm = $this->createDeleteForm( $id );
		$editForm   = $this->createEditForm( $entity );
		$editForm->handleRequest( $request );

		if ( $editForm->isValid() ) {

			$controller = $entity->getController();
			$pos        = strrpos( $controller, ":" );
			$action     = $pos === false ? $controller : substr( $controller, $pos + 1 );
			$entity->setController( substr( $controller, 0, $pos ) );
			$entity->setAction( $action );
			$em->flush();

			$this->get( 'session' )->getFlashBag()->add(
				'success',
				'Permiso Especial actualizado correctamente.'
			);

			return $this->redirect( $this->generateUrl( 'permiso_especial_edit', array( 'id' => $id ) ) );
		}

		return $this->render( 'UsuariosBundle:PermisoEspecial:edit.html.twig',
			array(
				'entity'      => $entity,
				'edit_form'   => $editForm->createView(),
				'delete_form' => $deleteForm->createView(),
			) );
	}

	/**
	 * Deletes a PermisoEspecial entity.
	 *
	 */
	public function deleteAction( Request $request, $id ) {
		$form = $this->createDeleteForm( $id );
		$form->handleRequest( $request );

		if ( $form->isValid() ) {
			$em     = $this->getDoctrine()->getManager();
			$entity = $em->getRepository( 'UsuariosBundle:PermisoEspecial' )->find( $id );

			if ( ! $entity ) {
				throw $this->createNotFoundException( 'Unable to find PermisoEspecial entity.' );
			}

			$em->remove( $entity );
			$em->flush();
		}

		return $this->redirect( $this->generateUrl( 'permiso_especial' ) );
	}

	/**
	 * Creates a form to delete a PermisoEspecial entity by id.
	 *
	 * @param mixed $id The entity id
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm( $id ) {
		return $this->createFormBuilder()
		            ->setAction( $this->generateUrl( 'permiso_especial_delete', array( 'id' => $id ) ) )
		            ->setMethod( 'DELETE' )
		            ->add( 'submit', 'submit', array( 'label' => 'Delete' ) )
		            ->getForm();
	}
}
