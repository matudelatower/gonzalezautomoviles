<?php

namespace UsuariosBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use UsuariosBundle\Entity\Usuario;
use UsuariosBundle\Form\UsuarioType;

/**
 * Usuario controller.
 *
 */
class UsuarioController extends Controller implements TokenAuthenticatedController {

	/**
	 * Lists all Usuario entities.
	 *
	 */
	public function indexAction() {
		$em = $this->getDoctrine()->getManager();

		$entities = $em->getRepository( 'UsuariosBundle:Usuario' )->findAll();

		return $this->render(
			'UsuariosBundle:Usuario:index.html.twig',
			array(
				'entities' => $entities,
			)
		);
	}

	/**
	 * Creates a new Usuario entity.
	 *
	 */
	public function createAction( Request $request ) {
		$entity = new Usuario();
		$form   = $this->createCreateForm( $entity );
		$form->handleRequest( $request );
		$muestraAlertPassword = false;
		$password             = $entity->getPassword();
		if ( $form->isValid() ) {

			if ( ! empty( $form->get( 'plain_password' )->getData() ) ) {
				$entity->setPlainPassword( $form->get( 'plain_password' )->getData() );
			} else {
				if ( ! $password ) {
					$password             = $this->get( 'manager.usuarios' )->randomPassword();
					$muestraAlertPassword = true;
				}
				$entity->setPassword( $password );
			}

			if ( $entity->getGrupos() ) {
				foreach ( $entity->getGrupos() as $grupo ) {
					$grupo->setUsuario( $entity );
				}
			}

			$em = $this->getDoctrine()->getManager();
			$em->persist( $entity );
			$em->flush();

			$this->get( 'session' )->getFlashBag()->add(
				'success',
				'Usuario creado correctamente.'
			);
			$this->get( 'session' )->getFlashBag()->add(
				'info',
				'El nuevo password generado automaticamente es: ' . $password
			);

			return $this->redirect( $this->generateUrl( 'usuario_show', array( 'id' => $entity->getId() ) ) );
		}

		return $this->render(
			'UsuariosBundle:Usuario:new.html.twig',
			array(
				'entity' => $entity,
				'form'   => $form->createView(),
			)
		);
	}

	/**
	 * Creates a form to create a Usuario entity.
	 *
	 * @param Usuario $entity The entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createCreateForm( Usuario $entity ) {
		$form = $this->createForm(
			new UsuarioType(),
			$entity,
			array(
				'action' => $this->generateUrl( 'usuario_create' ),
				'method' => 'POST',
				'attr'   => array( 'class' => 'box-body' )
			)
		);

		$form->add(
			'submit',
			'submit',
			array(
				'label' => 'Crear',
				'attr'  => array( 'class' => 'btn btn-primary pull-right' )
			)
		);

		return $form;
	}

	/**
	 * Displays a form to create a new Usuario entity.
	 *
	 */
	public function newAction() {
		$entity = new Usuario();
		$form   = $this->createCreateForm( $entity );

		return $this->render(
			'UsuariosBundle:Usuario:new.html.twig',
			array(
				'entity' => $entity,
				'form'   => $form->createView(),
			)
		);
	}

	/**
	 * Finds and displays a Usuario entity.
	 *
	 */
	public function showAction( $id ) {
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository( 'UsuariosBundle:Usuario' )->find( $id );

		if ( ! $entity ) {
			throw $this->createNotFoundException( 'Unable to find Usuario entity.' );
		}

//        $deleteForm = $this->createDeleteForm($id);

		return $this->render(
			'UsuariosBundle:Usuario:show.html.twig',
			array(
				'entity' => $entity,
//                'delete_form' => $deleteForm->createView(),
			)
		);
	}

	/**
	 * Displays a form to edit an existing Usuario entity.
	 *
	 */
	public function editAction( $id ) {
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository( 'UsuariosBundle:Usuario' )->find( $id );

		if ( ! $entity ) {
			throw $this->createNotFoundException( 'Unable to find Usuario entity.' );
		}

		$editForm   = $this->createEditForm( $entity );

		return $this->render(
			'UsuariosBundle:Usuario:edit.html.twig',
			array(
				'entity'      => $entity,
				'edit_form'   => $editForm->createView(),
			)
		);
	}

	/**
	 * Creates a form to edit a Usuario entity.
	 *
	 * @param Usuario $entity The entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createEditForm( Usuario $entity ) {
		$form = $this->createForm(
			new UsuarioType(),
			$entity,
			array(
				'action' => $this->generateUrl( 'usuario_update', array( 'id' => $entity->getId() ) ),
				'method' => 'PUT',
				'attr'   => array( 'class' => 'box-body' )
			)
		);

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
	 * Edits an existing Usuario entity.
	 *
	 */
	public function updateAction( Request $request, $id ) {
		$em = $this->getDoctrine()->getManager();

		$entity               = $em->getRepository( 'UsuariosBundle:Usuario' )->find( $id );
		$muestraAlertPassword = false;
		$password             = $entity->getPassword();

		if ( ! $entity ) {
			throw $this->createNotFoundException( 'No se encuentra el usuario.' );
		}

		$gruposOriginales = new ArrayCollection();

		// Crear un ArrayCollection de $permisoAplicacion
		foreach ( $entity->getGrupos() as $grupos ) {
			$gruposOriginales->add( $grupos );
		}

		$editForm = $this->createEditForm( $entity );
		$editForm->handleRequest( $request );

		if ( $editForm->isValid() ) {

			if ( ! empty( $editForm->get( 'plain_password' )->getData() ) ) {
				$entity->setPlainPassword( $editForm->get( 'plain_password' )->getData() );
			} else {
				if ( ! $password ) {
					$password             = $this->get( 'manager.usuarios' )->randomPassword();
					$muestraAlertPassword = true;

				}
				$entity->setPassword( $password );
			}

			foreach ( $gruposOriginales as $gruposOriginale ) {
				if ( false === $entity->getGrupos()->contains( $gruposOriginale ) ) {

					$gruposOriginale->setUsuario( null );
					$em->remove( $gruposOriginale );
				}
			}

			foreach ( $entity->getGrupos() as $grupo ) {
				$grupo->setUsuario( $entity );
			}

			$em->flush();

			$this->get( 'session' )->getFlashBag()->add(
				'success',
				'Usuario actualizado correctamente.'
			);
			if ( $muestraAlertPassword ) {
				$this->get( 'session' )->getFlashBag()->add(
					'info',
					'El nuevo password generado automaticamente es: ' . $password
				);
			}

			return $this->redirect( $this->generateUrl( 'usuario_edit', array( 'id' => $id ) ) );
		}

		return $this->render(
			'UsuariosBundle:Usuario:edit.html.twig',
			array(
				'entity'    => $entity,
				'edit_form' => $editForm->createView(),
//                'delete_form' => $deleteForm->createView(),
			)
		);
	}

	/**
	 * Deletes a Usuario entity.
	 *
	 */
	public function deleteAction( Request $request, $id ) {
		$form = $this->createDeleteForm( $id );
		$form->handleRequest( $request );

		if ( $form->isValid() ) {
			$em     = $this->getDoctrine()->getManager();
			$entity = $em->getRepository( 'UsuariosBundle:Usuario' )->find( $id );

			if ( ! $entity ) {
				throw $this->createNotFoundException( 'Unable to find Usuario entity.' );
			}

			$em->remove( $entity );
			$em->flush();
		}

		return $this->redirect( $this->generateUrl( 'usuario' ) );
	}

	/**
	 * Creates a form to delete a Usuario entity by id.
	 *
	 * @param mixed $id The entity id
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm( $id ) {
		return $this->createFormBuilder()
		            ->setAction( $this->generateUrl( 'usuario_delete', array( 'id' => $id ) ) )
		            ->setMethod( 'DELETE' )
		            ->add( 'submit', 'submit', array( 'label' => 'Delete' ) )
		            ->getForm();
	}
}
