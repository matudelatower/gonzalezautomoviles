<?php

namespace CRMBundle\Controller;

use CRMBundle\Entity\EncuestaResultadoCabecera;
use CRMBundle\Entity\LlamadaNoConcretada;
use CRMBundle\Form\LlamadaNoConcretadaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AjaxController extends Controller {
	public function getEncuestasAction( Request $request ) {

		$id = $request->get( 'id' );

		$vehiculo             = $this->getDoctrine()->getRepository( 'VehiculosBundle:Vehiculo' )->find( $id );
		$encuestasRealizadas  = $this->getDoctrine()->getRepository( 'CRMBundle:EncuestaResultadoCabecera' )->findByVehiculo( $vehiculo );
		$aEncuestasRealizadas = array();
		foreach ( $encuestasRealizadas as $encuestasRealizada ) {
			$aEncuestasRealizadas[] = $encuestasRealizada->getEncuesta()->getId();
		}

		$encuestas = $this->getDoctrine()->getRepository( 'CRMBundle:Encuesta' )->findEncuestasNoRelizadas( $aEncuestasRealizadas );
		$encuestas = $this->getDoctrine()->getRepository( 'CRMBundle:Encuesta' )->findAll();

		return $this->render( 'CRMBundle:Ajax:encuestas.html.twig',
			array(
				'encuestas' => $encuestas,
				'id'        => $id
			) );
	}

	public function llamadasNoConcretadasAction( Request $request ) {

		$id         = $request->get( 'id' );
		$encuestaId = $request->get( 'encuestaId' );

		$em = $this->getDoctrine()->getManager();

		$vehiculo = $em->getRepository( 'VehiculosBundle:Vehiculo' )->find( $id );
		$encuesta = $em->getRepository( 'CRMBundle:Encuesta' )->find( $encuestaId );

		$llamadaNoConcretada = new LlamadaNoConcretada();
		$llamadaNoConcretada->setVehiculo( $vehiculo );
		$llamadaNoConcretada->setEncuesta( $encuesta );

		$form = $this->createForm( new LlamadaNoConcretadaType(),
			$llamadaNoConcretada );

		if ( $request->getMethod() == 'POST' ) {
			$form->handleRequest( $request );
			if ( $form->isValid() ) {

				$cancelarEncuesta = $form->get( 'cancelarEncuesta' )->getData();
				if ( $cancelarEncuesta ) {
//					$this->get( 'manager.crm_encuestas' )->cancelarEncuesta( $llamadaNoConcretada->getEncuesta() );
					$encuestaResultadoCabecera = $em->getRepository( 'CRMBundle:EncuestaResultadoCabecera' )->findByVehiculo( $vehiculo );

					if ( ! $encuestaResultadoCabecera ) {
						$encuestaResultadoCabecera = new EncuestaResultadoCabecera();
						$encuestaResultadoCabecera->setVehiculo( $vehiculo );
					}
					$encuestaResultadoCabecera->setEncuesta( $encuesta );
					$encuestaResultadoCabecera->setCancelada( true );
					$em->persist( $encuestaResultadoCabecera );
				}

				$em->persist( $llamadaNoConcretada );
				$em->flush();

				$this->get( 'session' )->getFlashBag()->add(
					'success',
					'Registro creado correctamente.'
				);

				return $this->redirectToRoute( 'crm_homepage', array( 'slug' => $encuesta->getSlug() ) );
			}
		}


		return $this->render( 'CRMBundle:Ajax:llamadasNoConcretadas.html.twig',
			array(
				'form'     => $form->createView(),
				'id'       => $id,
				'encuesta' => $encuesta
			) );

	}

	public function getCantidadLlamadasNoConcretadasAction( Request $request ) {
		$id         = $request->get( 'id' );
		$encuestaId = $request->get( 'encuestaId' );

		$em = $this->getDoctrine()->getManager();

		$vehiculo = $em->getRepository( 'VehiculosBundle:Vehiculo' )->find( $id );
		$encuesta = $em->getRepository( 'CRMBundle:Encuesta' )->find( $encuestaId );
		$criteria = array(
			'vehiculo' => $vehiculo,
			'encuesta' => $encuesta
		);
		$cantidad = $em->getRepository( 'CRMBundle:LlamadaNoConcretada' )->findBy( $criteria );

		return new JsonResponse(count($cantidad));
	}
}
