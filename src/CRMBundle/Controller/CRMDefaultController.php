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

class CRMDefaultController extends Controller {

	public function indexAction( Request $request ) {

		$em           = $this->getDoctrine()->getManager();
		$slugEncuesta = $request->get( 'slug' );
		$encuesta     = $em->getRepository( 'CRMBundle:Encuesta' )->findOneBySlug( $slugEncuesta );

		if ( ! $encuesta ) {
			throw $this->createNotFoundException( 'No existe la encuesta ' . $slugEncuesta );
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
				'entities'          => $entities,
				'encuesta'          => $encuesta,
				'form'              => $form->createView(),
				'cantidadRegistros' => $cantidadRegistros,
			)
		);
	}

	public function indexEncuestasRealizadasAction( Request $request ) {

		$em           = $this->getDoctrine()->getManager();
		$slugEncuesta = $request->get( 'slug' );
		$encuesta     = $em->getRepository( 'CRMBundle:Encuesta' )->findOneBySlug( $slugEncuesta );

		if ( ! $encuesta ) {
			throw $this->createNotFoundException( 'No existe la encuesta ' . $slugEncuesta );
		}

		$encuestaResultadoCabecera = $em->getRepository( 'CRMBundle:EncuestaResultadoCabecera' )->findByEncuesta( $encuesta );

		$paginator = $this->get( 'knp_paginator' );
		$entities  = $paginator->paginate(
			$encuestaResultadoCabecera,
			$request->query->get( 'page', 1 )/* page number */,
			10/* limit per page */
		);

		return $this->render( '@CRM/Default/encuestasRealizadas.html.twig',
			array(
				'entities' => $entities
			) );
	}

	public function verEncuestaAction( $resultadoCabeceraId ) {

		$em                        = $this->getDoctrine()->getManager();
		$encuestaResultadoCabecera = $em->getRepository( 'CRMBundle:EncuestaResultadoCabecera' )->find( $resultadoCabeceraId );

		return $this->render( '@CRM/Default/ver.html.twig',
			array(
				'encuestaResultadoCabecera' => $encuestaResultadoCabecera
			) );
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

			return $this->redirectToRoute( 'crm_homepage', array( 'slug' => $encuesta->getSlug() ) );
		}

		return $this->redirectToRoute( 'crm_crear_encuesta_resultado',
			array(
				'vehiculoId' => $vehiculoId,
				'id'         => $id
			) );
	}

	public function reporteEncuestasRealizadasAction( Request $request ) {

		$em           = $this->getDoctrine()->getManager();
		$slugEncuesta = $request->get( 'slug' );
		$encuesta     = $em->getRepository( 'CRMBundle:Encuesta' )->findOneBySlug( $slugEncuesta );

		if ( ! $encuesta ) {
			throw $this->createNotFoundException( 'No existe la encuesta ' . $slugEncuesta );
		}

		$encuestaResultadoCabecera             = $em->getRepository( 'CRMBundle:EncuestaResultadoCabecera' )->findByEncuesta( $encuesta );
		$encuestaResultadoCabeceraNoCanceladas = $em->getRepository( 'CRMBundle:EncuestaResultadoCabecera' )->findByEncuestaNoCancelada( $encuesta );
		$cantidadEncuestas                     = count( $encuestaResultadoCabeceraNoCanceladas );
		$preguntas                             = $em->getRepository( 'CRMBundle:EncuestaPregunta' )->findByEncuesta( $encuesta );
		$aOpciones                             = array();
		foreach ( $preguntas as $pregunta ) {
			foreach ( $pregunta->getOpcionesRespuestas() as $opcionesRespuesta ) {
				$aOpciones[ $opcionesRespuesta->getId() ] = array(
					'texto_opcion'  => $opcionesRespuesta->getTextoOpcion(),
					'valor_literal' => $opcionesRespuesta->getValorLiteral(),
				);
			}
		}

		$aValoresIpc = array(
			1 => 0,
			2 => 25,
			3 => 50,
			4 => 75,
			5 => 100,
		);


		$aOpciones['promotores']  = 'Promotores';
		$aOpciones['neutros']     = 'Neutros';
		$aOpciones['detractores'] = 'Detractores';


		$aResultados = array();
		foreach ( $encuestaResultadoCabecera as $cabecera ) {

			foreach ( $cabecera->getEncuestaResultadoRespuesta() as $resultdoRespuesta ) {
				if ( $resultdoRespuesta->getEncuestaPregunta()->getIpc() ) {
					if ( isset( $aResultados[ $resultdoRespuesta->getEncuestaPregunta()->getPregunta() ][ $resultdoRespuesta->getEncuestaOpcionRespuesta()->getId() ] ) ) {
						$aResultados[ $resultdoRespuesta->getEncuestaPregunta()->getPregunta() ][ $resultdoRespuesta->getEncuestaOpcionRespuesta()->getId() ] += 1;
					} else {
						$aResultados[ $resultdoRespuesta->getEncuestaPregunta()->getPregunta() ][ $resultdoRespuesta->getEncuestaOpcionRespuesta()->getId() ] = 1;
					}
				} elseif ( $resultdoRespuesta->getEncuestaPregunta()->getNps() ) {
					if ( $resultdoRespuesta->getEncuestaOpcionRespuesta()->getTextoOpcion() >= 9 ) {
						if ( isset( $aResultados[ $resultdoRespuesta->getEncuestaPregunta()->getPregunta() ]['promotores'] ) ) {
							$aResultados[ $resultdoRespuesta->getEncuestaPregunta()->getPregunta() ]['promotores'] += 1;
						} else {
							$aResultados[ $resultdoRespuesta->getEncuestaPregunta()->getPregunta() ]['promotores'] = 1;
						}
					} elseif ( $resultdoRespuesta->getEncuestaOpcionRespuesta()->getTextoOpcion() >= 7 ) {
						if ( isset( $aResultados[ $resultdoRespuesta->getEncuestaPregunta()->getPregunta() ]['neutros'] ) ) {
							$aResultados[ $resultdoRespuesta->getEncuestaPregunta()->getPregunta() ]['neutros'] += 1;
						} else {
							$aResultados[ $resultdoRespuesta->getEncuestaPregunta()->getPregunta() ]['neutros'] = 1;
						}
					} elseif ( $resultdoRespuesta->getEncuestaOpcionRespuesta()->getTextoOpcion() <= 7 ) {
						if ( isset( $aResultados[ $resultdoRespuesta->getEncuestaPregunta()->getPregunta() ]['detractores'] ) ) {
							$aResultados[ $resultdoRespuesta->getEncuestaPregunta()->getPregunta() ]['detractores'] += 1;
						} else {
							$aResultados[ $resultdoRespuesta->getEncuestaPregunta()->getPregunta() ]['detractores'] = 1;
						}
					}
					if ( ! isset( $aResultados[ $resultdoRespuesta->getEncuestaPregunta()->getPregunta() ]['promotores'] ) ) {
						$aResultados[ $resultdoRespuesta->getEncuestaPregunta()->getPregunta() ]['promotores'] = 0;
					}
					if ( ! isset( $aResultados[ $resultdoRespuesta->getEncuestaPregunta()->getPregunta() ]['neutros'] ) ) {
						$aResultados[ $resultdoRespuesta->getEncuestaPregunta()->getPregunta() ]['neutros'] = 0;
					}
					if ( ! isset( $aResultados[ $resultdoRespuesta->getEncuestaPregunta()->getPregunta() ]['detractores'] ) ) {
						$aResultados[ $resultdoRespuesta->getEncuestaPregunta()->getPregunta() ]['detractores'] = 0;
					}
				} else {
					if ( isset( $aResultados[ $resultdoRespuesta->getEncuestaPregunta()->getPregunta() ][ $resultdoRespuesta->getEncuestaOpcionRespuesta()->getId() ] ) ) {
						$aResultados[ $resultdoRespuesta->getEncuestaPregunta()->getPregunta() ][ $resultdoRespuesta->getEncuestaOpcionRespuesta()->getId() ] += 1;
					} else {
						$aResultados[ $resultdoRespuesta->getEncuestaPregunta()->getPregunta() ][ $resultdoRespuesta->getEncuestaOpcionRespuesta()->getId() ] = 1;
					}
				}
				$aResultados[ $resultdoRespuesta->getEncuestaPregunta()->getPregunta() ]['objetivo'] = $resultdoRespuesta->getEncuestaPregunta()->getObjetivo();
				$aResultados[ $resultdoRespuesta->getEncuestaPregunta()->getPregunta() ]['media']    = $resultdoRespuesta->getEncuestaPregunta()->getMedia();
				$aResultados[ $resultdoRespuesta->getEncuestaPregunta()->getPregunta() ]['ipc']      = $resultdoRespuesta->getEncuestaPregunta()->getIpc();
				$aResultados[ $resultdoRespuesta->getEncuestaPregunta()->getPregunta() ]['nps']      = $resultdoRespuesta->getEncuestaPregunta()->getNps();
			}

		}

//		echo '<pre>';
//		print_r( $aOpciones );
//		print_r( $aResultados );
//		exit;

		return $this->render( '@CRM/Default/reporteEncuestasRealizadas.html.twig',
			array(
				'encuestaResultadoCabecera' => $encuestaResultadoCabecera,
				'resultados'                => $aResultados,
				'cantidadEncuestas'         => $cantidadEncuestas,
				'opciones'                  => $aOpciones,
				'aValoresIpc'               => $aValoresIpc
			) );
	}
}
