<?php

namespace CuestionariosBundle\Controller;

use CuestionariosBundle\Entity\EncuestaResultadoCabecera;
use CuestionariosBundle\Entity\EncuestaResultadoRespuesta;
use CuestionariosBundle\Form\AlertaTempranaParameterType;
use CuestionariosBundle\Form\Model\AlertaTempranaParameter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CuestionariosBundle\Entity\Encuesta;
use CuestionariosBundle\Form\EncuestaType;

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

		$entities = $em->getRepository( 'CuestionariosBundle:Encuesta' )->findAll();

		$paginator = $this->get( 'knp_paginator' );
		$entities  = $paginator->paginate(
			$entities,
			$request->query->get( 'page', 1 )/* page number */,
			10/* limit per page */
		);

		return $this->render( 'CuestionariosBundle:Encuesta:index.html.twig',
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

			return $this->redirect( $this->generateUrl( 'encuestas_show', array( 'id' => $entity->getId() ) ) );
		}

		return $this->render( 'CuestionariosBundle:Encuesta:new.html.twig',
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
				'action' => $this->generateUrl( 'encuestas_create' ),
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

		return $this->render( 'CuestionariosBundle:Encuesta:new.html.twig',
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

		$entity = $em->getRepository( 'CuestionariosBundle:Encuesta' )->find( $id );

		if ( ! $entity ) {
			throw $this->createNotFoundException( 'Unable to find Encuesta entity.' );
		}

		$deleteForm = $this->createDeleteForm( $id );

		return $this->render( 'CuestionariosBundle:Encuesta:show.html.twig',
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

		$entity = $em->getRepository( 'CuestionariosBundle:Encuesta' )->find( $id );

		if ( ! $entity ) {
			throw $this->createNotFoundException( 'Unable to find Encuesta entity.' );
		}

		$editForm   = $this->createEditForm( $entity );
		$deleteForm = $this->createDeleteForm( $id );

		return $this->render( 'CuestionariosBundle:Encuesta:edit.html.twig',
			array(
				'entity'      => $entity,
				'edit_form'   => $editForm->createView(),
				'delete_form' => $deleteForm->createView(),
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
				'action' => $this->generateUrl( 'encuestas_update', array( 'id' => $entity->getId() ) ),
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
	 * Edits an existing Encuesta entity.
	 *
	 */
	public function updateAction( Request $request, $id ) {
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository( 'CuestionariosBundle:Encuesta' )->find( $id );

		if ( ! $entity ) {
			throw $this->createNotFoundException( 'Unable to find Encuesta entity.' );
		}

		$deleteForm = $this->createDeleteForm( $id );
		$editForm   = $this->createEditForm( $entity );
		$editForm->handleRequest( $request );

		if ( $editForm->isValid() ) {
			$em->flush();

			$this->get( 'session' )->getFlashBag()->add(
				'success',
				'Encuesta actualizado correctamente.'
			);

			return $this->redirect( $this->generateUrl( 'encuestas_edit', array( 'id' => $id ) ) );
		}

		return $this->render( 'CuestionariosBundle:Encuesta:edit.html.twig',
			array(
				'entity'      => $entity,
				'edit_form'   => $editForm->createView(),
				'delete_form' => $deleteForm->createView(),
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
			$entity = $em->getRepository( 'CuestionariosBundle:Encuesta' )->find( $id );

			if ( ! $entity ) {
				throw $this->createNotFoundException( 'Unable to find Encuesta entity.' );
			}

			$em->remove( $entity );
			$em->flush();
		}

		return $this->redirect( $this->generateUrl( 'encuestas' ) );
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
		            ->setAction( $this->generateUrl( 'encuestas_delete', array( 'id' => $id ) ) )
		            ->setMethod( 'DELETE' )
		            ->add( 'submit', 'submit', array( 'label' => 'Delete' ) )
		            ->getForm();
	}

	public function crearAlertaTempranaAction( Request $request, $vehiculoId ) {

		$em = $this->getDoctrine()->getManager();

		$vehiculo = $em->getRepository( 'VehiculosBundle:Vehiculo' )->find( $vehiculoId );

		$encuesta = $em->getRepository( 'CuestionariosBundle:Encuesta' )->findOneBySlug( 'alerta-temprana' );

		$preguntas = $em->getRepository( 'CuestionariosBundle:EncuestaPregunta' )->findByEncuesta( $encuesta );


		if ( $request->getMethod() == 'POST' ) {

			$alertaTemprana = $request->get( 'cuestionarios_bundle_alerta_temprana_parameter_type' );

			$encuestaResultadoCabecera = new EncuestaResultadoCabecera();
			$encuestaResultadoCabecera->setVehiculo( $vehiculo );

			foreach ( $alertaTemprana as $preguntaId => $valor ) {

				$resultadoRespuesta = new EncuestaResultadoRespuesta();
				$resultadoRespuesta->setEncuestaResultadoCabecera( $encuestaResultadoCabecera );

				$pregunta                = $em->getRepository( 'CuestionariosBundle:EncuestaPregunta' )->findOneById( $preguntaId );
				$criteria                = array(
					'encuestaPregunta' => $pregunta,
					'textoOpcion'      => $valor
				);
				$encuestaOpcionRespuesta = $em->getRepository( 'CuestionariosBundle:EncuestaOpcionRespuesta' )->findOneBy($criteria);
				$resultadoRespuesta->setEncuestaOpcionRespuesta( $encuestaOpcionRespuesta );
				$resultadoRespuesta->setEncuestaPregunta( $pregunta );
				$em->persist( $resultadoRespuesta );
			}

			$em->flush();

			$this->get( 'session' )->getFlashBag()->add(
				'success',
				'Cuestionario guardado correctamente. <br> Muchas Gracias Por su tiempo.'
			);

			return $this->redirectToRoute( 'app_pantalla_vacia' );

		}

		return $this->render( 'CuestionariosBundle:Encuesta:formAlertaTemprana.html.twig',
			array(
				'vehiculo'  => $vehiculo,
				'preguntas' => $preguntas,
				'encuesta'  => $encuesta,
			) );
	}

	public function getOpcionesPorPreguntaAction( $id ) {
		$em = $this->getDoctrine()->getManager();

//		$pregunta = $em->getRepository( 'CuestionariosBundle:EncuestaPregunta' )->findOneById( $id );

		$encuesta = $em->getRepository( 'CuestionariosBundle:Encuesta' )->find( $id );

		$encuestaPreguntas = $em->getRepository( 'CuestionariosBundle:EncuestaPregunta' )->findByEncuesta( $encuesta );
//		$opcionesPregunta = $em->getRepository( 'CuestionariosBundle:EncuestaOpcionRespuesta' )->findByEncuestaPregunta( $pregunta );

		if ( ! $encuesta ) {
			throw $this->createNotFoundException( 'No se encuentra la encuesta' );
		}

		$alertaTempranaParameter = new AlertaTempranaParameter( $encuestaPreguntas, $em );
		$form                    = $this->createForm( new AlertaTempranaParameterType(), $alertaTempranaParameter );


		return $this->render(
			'CuestionariosBundle:Cuestionario:campos.html.twig',
			array(
				'form' => $form->createView(),
			)
		);

	}
}
