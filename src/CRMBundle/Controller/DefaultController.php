<?php

namespace CRMBundle\Controller;

use CRMBundle\Entity\EncuestaResultadoCabecera;
use CRMBundle\Entity\EncuestaResultadoRespuesta;
use CRMBundle\Form\EncuestaOpcionRespuestaType;
use CRMBundle\Form\EncuestaParameterType;
use CRMBundle\Form\Filter\CRMFilterType;
use CRMBundle\Form\Model\EncuestaParameter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VehiculosBundle\Form\VehiculoFilterType;

class DefaultController extends Controller {

	public function indexAction( Request $request ) {

		$em           = $this->getDoctrine()->getManager();
		$slugEncuesta = $request->get( 'slug' );
		$encuesta     = $em->getRepository( 'CRMBundle:Encuesta' )->findOneBySlug( $slugEncuesta );

		if ( ! $encuesta ) {
			throw $this->createNotFoundException( 'No existe la encuesta '. $slugEncuesta );
		}

		$form      = $this->createForm( new CRMFilterType() );
		$estadoId1 = $em->getRepository( 'VehiculosBundle:TipoEstadoVehiculo' )->findOneBySlug( 'entregado' );
		$estados   = array( $estadoId1 );
		$order     = " fecha_estado DESC, modelo_nombre ASC,color_vehiculo ASC, v.vin ASC";
		if ( $request->isMethod( "post" ) ) {
			$form->handleRequest( $request );
			if ( $form->isValid() ) {
				$data = $form->getData();
				if ( $data['rango'] ) {
					$aFecha = explode( ' - ', $data['rango'] );

					$fechaDesde = \DateTime::createFromFormat( 'd/m/Y', $aFecha[0] );
					$fechaHasta = \DateTime::createFromFormat( 'd/m/Y', $aFecha[1] );

					$data['fechaDesde'] = $fechaDesde->format( 'Y-m-d' ) . ' 00:00:00';
					$data['fechaHasta'] = $fechaHasta->format( 'Y-m-d' ) . ' 23:59:59';
				}
				$entities = $em->getRepository( 'VehiculosBundle:Vehiculo' )->getVehiculosEstadoCRM( $estados,
					$data,
					$order,
					$slugEncuesta );
			}
		} else {
			$entities = $em->getRepository( 'VehiculosBundle:Vehiculo' )->getVehiculosEstadoCRM( $estados,
				null,
				$order,
				$slugEncuesta );
		}
		$cantidadRegistros = count( $entities );

		$paginator = $this->get( 'knp_paginator' );
		if ( $request->request->get( 'crmbundle_vehiculo_filter' )['registrosPaginador'] != "" ) {
			$limit = $request->request->get( 'crmbundle_vehiculo_filter' )['registrosPaginador'];
		} else {
			$limit = 10;
		}
		$entities = $paginator->paginate(
			$entities,
			$request->query->get( 'page', 1 )/* page number */,
			$limit/* limit per page */
		);

		return $this->render(
			'CRMBundle:Default:index.html.twig',
			array(
				'entities'             => $entities,
				'encuesta'             => $encuesta,
				'form'                 => $form->createView(),
				'cantidadRegistros'    => $cantidadRegistros,
				'muestraRangoFecha'    => true,
				'muestraFiltroReventa' => true,
				'labelRangoFecha'      => 'Fecha entregado',
				'muestraExportarExcel' => false,
				'muestraExportarPdf'   => false,
			)
		);
	}

	public function encuestaAction( Request $request ) {

		$encuestaId = $request->get( 'encuesta' );
		$vehiculoId = $request->get( 'id' );

		return $this->redirectToRoute( 'crm_nueva_encuesta_resultado',
			array(
				'id'         => $encuestaId,
				'vehiculoId' => $vehiculoId
			) );


	}

	public function nuevaEncuestaAction( $id, $vehiculoId ) {
		$em       = $this->getDoctrine()->getManager();
		$encuesta = $em->getRepository( 'CRMBundle:Encuesta' )->findOrdenado( $id );

		$preguntas = $encuesta->getPreguntas();

		$encuestaParameter = new EncuestaParameter( $preguntas, $em );
		$form              = $this->createForm( new EncuestaParameterType(),
			$encuestaParameter,
			array(
				'action' => $this->generateUrl( 'crm_crear_encuesta_resultado',
					array(
						'id'         => $id,
						'vehiculoId' => $vehiculoId
					) ),
				'method' => 'POST',
				'attr'   => array( 'class' => 'box-body' )
			) );

		$form->add( 'submit',
			'submit',
			array(
				'label' => 'Crear',
				'attr'  => array( 'class' => 'btn btn-primary pull-right' )
			) );


		return $this->render( 'CRMBundle:Encuesta:encuesta.html.twig',
			array(
				'form'     => $form->createView(),
				'encuesta' => $encuesta
			) );
	}

	public function crearEncuestaAction( Request $request, $id, $vehiculoId ) {

		$em = $this->getDoctrine()->getManager();

		$resultado = $request->get( 'crm_bundle_encuesta_parameter_type' );

		if ( $request->getMethod() == 'POST' ) {

			$encuesta = $em->getRepository( 'CRMBundle:Encuesta' )->find( $id );
			$vehiculo = $em->getRepository( 'VehiculosBundle:Vehiculo' )->find( $vehiculoId );

			$resultadoCabecera = new EncuestaResultadoCabecera();

			foreach ( $resultado as $k => $value ) {
				if ( $k !== 'submit' ) {
					$resultadoRespuesta = new EncuestaResultadoRespuesta();
					$pregunta           = $em->getRepository( 'CRMBundle:EncuestaPregunta' )->find( $k );
					$resultadoRespuesta->setEncuestaPregunta( $pregunta );
					$opcionRespuesta = $em->getRepository( 'CRMBundle:EncuestaOpcionRespuesta' )->find( $value );
					$resultadoRespuesta->setEncuestaOpcionRespuesta( $opcionRespuesta );

					$resultadoRespuesta->setEncuestaResultadoCabecera( $resultadoCabecera );

					$em->persist( $resultadoRespuesta );
				}
			}

			$resultadoCabecera->setVehiculo( $vehiculo );
			$resultadoCabecera->setEncuesta( $encuesta );
			$em->persist( $resultadoCabecera );

			$em->flush();

			$this->get( 'session' )->getFlashBag()->add(
				'success',
				'Encuesta creada correctamente'
			);

			return $this->redirectToRoute( 'crm_homepage',  array( 'slug' => $encuesta->getSlug() )  );
		}

		return $this->redirectToRoute( 'crm_crear_encuesta_resultado',
			array(
				'vehiculoId' => $vehiculoId,
				'id'         => $id
			) );
	}
}
