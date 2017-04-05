<?php

namespace CRMBundle\Controller;

use CRMBundle\Entity\LlamadaNoConcretada;
use CRMBundle\Form\LlamadaNoConcretadaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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

		return $this->render( 'CRMBundle:Ajax:encuestas.html.twig',
			array(
				'encuestas' => $encuestas,
				'id'        => $id
			) );
	}

	public function llamadasNoConcretadasAction( Request $request ) {

		$id                   = $request->get( 'id' );
		$vehiculo             = $this->getDoctrine()->getRepository( 'VehiculosBundle:Vehiculo' )->find( $id );
		$encuestasRealizadas  = $this->getDoctrine()->getRepository( 'CRMBundle:EncuestaResultadoCabecera' )->findByVehiculo( $vehiculo );
		$aEncuestasRealizadas = array();
		foreach ( $encuestasRealizadas as $encuestasRealizada ) {
			$aEncuestasRealizadas[] = $encuestasRealizada->getEncuesta()->getId();
		}

		$llamadaNoConcretada = new LlamadaNoConcretada();
		$llamadaNoConcretada->setVehiculo( $vehiculo );

		$form = $this->createForm( new LlamadaNoConcretadaType(),
			$llamadaNoConcretada,
			array(
				'encuestas_realizadas' => $aEncuestasRealizadas
			) );

		if ( $request->getMethod() == 'POST' ) {
			$form->handleRequest( $request );
			if ( $form->isValid() ) {

				$cancelarEncuesta = $form->get( 'cancelarEncuesta' )->getData();
				if ( $cancelarEncuesta ) {
					$this->get( 'manager.crm_encuestas' )->cancelarEncuesta( $llamadaNoConcretada->getEncuesta() );
				}

				$em = $this->getDoctrine()->getManager();
				$em->persist( $llamadaNoConcretada );
				$em->flush();

				$this->get( 'session' )->getFlashBag()->add(
					'success',
					'Registro creado correctamente.'
				);

				return $this->redirectToRoute( 'crm_homepage' );
			}
		}


		return $this->render( 'CRMBundle:Ajax:llamadasNoConcretadas.html.twig',
			array(
				'form' => $form->createView(),
				'id'   => $id
			) );

	}
}
