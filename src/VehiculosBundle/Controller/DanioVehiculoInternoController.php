<?php

namespace VehiculosBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use VehiculosBundle\Entity\DanioVehiculoInterno;
use VehiculosBundle\Form\CheckListPreEntregaType;
use VehiculosBundle\Form\DanioVehiculoInternoType;
use Symfony\Component\HttpFoundation\Request;
use UsuariosBundle\Controller\TokenAuthenticatedController;

class DanioVehiculoInternoController extends Controller implements TokenAuthenticatedController{
	public function editarDanioInternoAction( Request $request, $vehiculoId ) {

		$em = $this->getDoctrine()->getManager();

		$vehiculo = $em->getRepository( 'VehiculosBundle:Vehiculo' )->find( $vehiculoId );

		$daniosInternos = new ArrayCollection();

		// Create an ArrayCollection of the current Tag objects in the database
		foreach ($vehiculo->getDanioVehiculoInterno() as $danioInterno) {
			$daniosInternos->add($danioInterno);
		}

		$formDaniosInternos = $this->createForm( new CheckListPreEntregaType(), $vehiculo );


		if ( $request->getMethod() == 'POST' ) {
			$formDaniosInternos->handleRequest( $request );
			if ( $formDaniosInternos->isValid() ) {
				$vehiculosManager = $this->get( 'manager.vehiculos' );
				$vehiculo         = $vehiculosManager->modificarDanioInterno( $vehiculo , $daniosInternos);

				$this->get( 'session' )->getFlashBag()->add(
					'success',
					'Daños modificados correctamente'
				);
			}
		}

		return $this->render( 'VehiculosBundle:DanioVehiculoInterno:editarDanioVehiculoInterno.html.twig',
			array(
				'vehiculo'       => $vehiculo,
				'formDanioInterno' => $formDaniosInternos->createView(),
			) );
	}
}
