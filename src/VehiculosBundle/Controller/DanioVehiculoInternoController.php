<?php

namespace VehiculosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use VehiculosBundle\Entity\DanioVehiculoInterno;
use VehiculosBundle\Form\CheckListPreEntregaType;
use VehiculosBundle\Form\DanioVehiculoInternoType;
use Symfony\Component\HttpFoundation\Request;

class DanioVehiculoInternoController extends Controller {
	public function editarDanioInternoAction( Request $request, $vehiculoId ) {

		$em = $this->getDoctrine()->getManager();

		$vehiculo = $em->getRepository( 'VehiculosBundle:Vehiculo' )->find( $vehiculoId );

		$formDaniosInternos = $this->createForm( new CheckListPreEntregaType(), $vehiculo );

		if ( $request->getMethod() == 'POST' ) {
			$formDaniosInternos->handleRequest( $request );
			if ( $formDaniosInternos->isValid() ) {
				$vehiculosManager = $this->get( 'manager.vehiculos' );
				$vehiculo         = $vehiculosManager->modificarDanioInterno( $vehiculo );
				$em->persist( $vehiculo );
				$em->flush();

				$this->get( 'session' )->getFlashBag()->add(
					'success',
					'Daños modificados correctamente'
				);
			}
		}

		return $this->render( 'VehiculosBundle:DanioVehiculoInterno:editarDanioVehiculoInterno.html.twig',
			array(
				'vehiculoId'       => $vehiculoId,
				'formDanioInterno' => $formDaniosInternos->createView(),
			) );
	}
}
