<?php

namespace PersonasBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use PersonasBundle\Entity\CategoriaEmpleado;
use PersonasBundle\Entity\EmpleadoCategoria;
use PersonasBundle\Entity\Persona;
use PersonasBundle\Entity\PersonaTipo;
use PersonasBundle\Form\BuscadorPersonaType;
use PersonasBundle\Form\PersonaEmpleadoType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UsuariosBundle\Controller\TokenAuthenticatedController;

use PersonasBundle\Entity\Empleado;
use PersonasBundle\Form\EmpleadoType;

/**
 * Empleado controller.
 *
 */
class EmpleadoController extends Controller implements TokenAuthenticatedController{

	/**
	 * Lists all Empleado entities.
	 *
	 */
	public function indexAction( Request $request ) {
		$em = $this->getDoctrine()->getManager();

		$entities = $em->getRepository( 'PersonasBundle:Empleado' )->findAll();

		$paginator = $this->get( 'knp_paginator' );
		$entities  = $paginator->paginate(
			$entities,
			$request->query->get( 'page', 1 )/* page number */,
			10/* limit per page */
		);

		return $this->render( 'PersonasBundle:Empleado:index.html.twig',
			array(
				'entities' => $entities,
			) );
	}

	/**
	 * Creates a new Empleado entity.
	 *
	 */
	public function createAction( Request $request ) {

		$entity = new PersonaTipo();

		$form                 = $this->createCreateForm( $entity );
		$muestraAlertPassword = false;

		$password = $entity->getUsuario() ? $entity->getUsuario()->getPassword() : null;

		$form->handleRequest( $request );

		if ( $form->isValid() ) {

			foreach ( $entity->getEmpleado()->getEmpleadoCategoria() as $empleadoCategoria ) {
				$empleadoCategoria->setEmpleado( $entity->getEmpleado() );
			}


			if ( ! empty( $form->get( 'usuario' )->get( 'plain_password' )->getData() ) ) {
				$entity->getUsuario()->setPlainPassword( $form->get( 'usuario' )->get( 'plain_password' )->getData() );
			} else {
				if ( ! $password ) {
					$password             = $this->get( 'manager.usuarios' )->randomPassword();
					$muestraAlertPassword = true;
				}
				$entity->getUsuario()->setPassword( $password );
			}


			if ( $entity->getUsuario()->getGrupos() ) {
				foreach ( $entity->getUsuario()->getGrupos() as $grupo ) {
					$grupo->setUsuario( $entity->getUsuario() );
				}
			}

			$em = $this->getDoctrine()->getManager();
			$em->persist( $entity );
			$em->flush();

			$this->get( 'session' )->getFlashBag()->add(
				'success',
				'Empleado creado correctamente.'
			);

			if ( $muestraAlertPassword ) {
				$this->get( 'session' )->getFlashBag()->add(
					'info',
					'El nuevo password generado automaticamente es: ' . $password
				);
			}

			return $this->redirect( $this->generateUrl( 'empleados_show', array( 'id' => $entity->getId() ) ) );
		}

		return $this->render( 'PersonasBundle:Empleado:new.html.twig',
			array(
				'entity' => $entity,
				'form'   => $form->createView(),
			) );
	}

	/**
	 * Creates a form to create a Empleado entity.
	 *
	 * @param Empleado $entity The entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createCreateForm( PersonaTipo $entity ) {
		$form = $this->createForm( new PersonaEmpleadoType(),
//		$form = $this->createForm( new PersonaEmpleadoType(),
			$entity,
			array(
				'action' => $this->generateUrl( 'empleados_create' ),
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

	public function nuevoEmpleadoAction( Request $request ) {


		$form = $this->get( 'manager.personas' )->formBuscadorPersonas( 'empleados_new' );


		return $this->render( 'PersonasBundle:Default:buscadorPersona.html.twig',
			array(

				'form' => $form->createView(),
			) );
	}

	/**
	 * Displays a form to create a new Empleado entity.
	 *
	 */
	public function newAction( Request $request ) {


		$em   = $this->getDoctrine()->getManager();
		$form = $this->get( 'manager.personas' )->formBuscadorPersonas( 'empleados_new' );
		$form->handleRequest( $request );
		$criteria = null;
		if ( $request->getMethod() == 'POST' ) {
			$data     = $form->getData();
			$criteria = array(
				'numeroDocumento' => $data['numeroDocumento'],
				'tipoDocumento'   => $data['tipoDocumento'],
			);

			$persona = $em->getRepository( 'PersonasBundle:Persona' )->findOneBy( $criteria );

		}

		$entity = new PersonaTipo();

		if ( ! $persona ) {
			$persona = new Persona();
			$persona->setNumeroDocumento( $criteria['numeroDocumento'] );
			$persona->setTipoDocumento( $criteria['tipoDocumento'] );
		}
		$entity->setPersona( $persona );

		$form = $this->createCreateForm( $entity );

		return $this->render( 'PersonasBundle:Empleado:new.html.twig',
			array(
				'entity' => $entity,
				'form'   => $form->createView(),
			) );
	}


	/**
	 * Finds and displays a Empleado entity.
	 *
	 */
	public function showAction( $id ) {
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository( 'PersonasBundle:Empleado' )->find( $id );

		if ( ! $entity ) {
			$personaTipo = $em->getRepository( 'PersonasBundle:PersonaTipo' )->find( $id );
			$entity      = $personaTipo->getEmpleado();
			if ( ! $entity ) {
				throw $this->createNotFoundException( 'Unable to find Empleado entity.' );
			}
		}

		$deleteForm = $this->createDeleteForm( $id );

		return $this->render( 'PersonasBundle:Empleado:show.html.twig',
			array(
				'entity'      => $entity,
				'delete_form' => $deleteForm->createView(),
			) );
	}

	/**
	 * Displays a form to edit an existing Empleado entity.
	 *
	 */
	public function editAction( $id ) {
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository( 'PersonasBundle:Empleado' )->find( $id );

		$personaTipo = $em->getRepository( 'PersonasBundle:PersonaTipo' )->findOneByEmpleado( $entity );

		if ( ! $entity ) {
			throw $this->createNotFoundException( 'Unable to find Empleado entity.' );
		}

		$editForm = $this->createEditForm( $personaTipo );

//		$deleteForm = $this->createDeleteForm( $id );

		return $this->render( 'PersonasBundle:Empleado:edit.html.twig',
			array(
				'entity'    => $entity,
				'edit_form' => $editForm->createView(),
//				'delete_form' => $deleteForm->createView(),
			) );
	}

	/**
	 * Creates a form to edit a Empleado entity.
	 *
	 * @param Empleado $entity The entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createEditForm( PersonaTipo $entity ) {
		$form = $this->createForm( new PersonaEmpleadoType(),
			$entity,
			array(
				'action' => $this->generateUrl( 'empleados_update', array( 'id' => $entity->getId() ) ),
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
	 * Edits an existing Empleado entity.
	 *
	 */
	public function updateAction( Request $request, $id ) {
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository( 'PersonasBundle:PersonaTipo' )->find( $id );

		if ( ! $entity ) {
			throw $this->createNotFoundException( 'Unable to find Empleado entity.' );
		}

		$muestraAlertPassword = false;
		$factory = $this->get('security.encoder_factory');

		$usuario = $entity->getUsuario();

		$encoder = $factory->getEncoder($usuario);
		$password             = $usuario ? $usuario->getPassword() : null;


		$deleteForm = $this->createDeleteForm( $id );
		$editForm   = $this->createEditForm( $entity );
		$editForm->handleRequest( $request );

		if ( $editForm->isValid() ) {

			foreach ( $entity->getEmpleado()->getEmpleadoCategoria() as $empleadoCategoria ) {
				$empleadoCategoria->setEmpleado( $entity->getEmpleado() );
			}

			if ( ! empty( $editForm->get( 'usuario' )->get( 'plain_password' )->getData() ) ) {

				$password = $encoder->encodePassword($editForm->get( 'usuario' )->get( 'plain_password' )->getData(), $usuario->getSalt());

				$usuario->setPassword( $password );
			} else {
				if ( ! $password ) {
					$password             = $this->get( 'manager.usuarios' )->randomPassword();
					$password = $encoder->encodePassword($password, $usuario->getSalt());
					$muestraAlertPassword = true;

				}
				$usuario->setPassword( $password );
			}

			if ( $usuario->getGrupos() ) {
				foreach ( $usuario->getGrupos() as $grupo ) {
					$grupo->setUsuario( $usuario );
				}
			}

			$em->flush();

			$this->get( 'session' )->getFlashBag()->add(
				'success',
				'Empleado actualizado correctamente.'
			);
			if ( $muestraAlertPassword ) {
				$this->get( 'session' )->getFlashBag()->add(
					'info',
					'El nuevo password generado automaticamente es: ' . $password
				);
			}

			return $this->redirect( $this->generateUrl( 'empleados_edit',
				array( 'id' => $entity->getEmpleado()->getId() ) ) );
		}

		return $this->render( 'PersonasBundle:Empleado:edit.html.twig',
			array(
				'entity'      => $entity,
				'edit_form'   => $editForm->createView(),
				'delete_form' => $deleteForm->createView(),
			) );
	}

	/**
	 * Deletes a Empleado entity.
	 *
	 */
	public function deleteAction( Request $request, $id ) {
		$form = $this->createDeleteForm( $id );
		$form->handleRequest( $request );

		if ( $form->isValid() ) {
			$em     = $this->getDoctrine()->getManager();
			$entity = $em->getRepository( 'PersonasBundle:Empleado' )->find( $id );

			if ( ! $entity ) {
				throw $this->createNotFoundException( 'Unable to find Empleado entity.' );
			}

			$em->remove( $entity );
			$em->flush();
		}

		return $this->redirect( $this->generateUrl( 'empleados' ) );
	}

	/**
	 * Creates a form to delete a Empleado entity by id.
	 *
	 * @param mixed $id The entity id
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm( $id ) {
		return $this->createFormBuilder()
		            ->setAction( $this->generateUrl( 'empleados_delete', array( 'id' => $id ) ) )
		            ->setMethod( 'DELETE' )
		            ->add( 'submit', 'submit', array( 'label' => 'Delete' ) )
		            ->getForm();
	}
}
