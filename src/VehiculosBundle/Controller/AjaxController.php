<?php

namespace VehiculosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AjaxController extends Controller {
	public function getMuestraCamposPlanDeAhorroAction( Request $request ) {


		$id = $request->query->get( 'id' );

		if ( ! $id ) {
			$return = false;
		} else {

			$em       = $this->getDoctrine()->getManager();
			$entities = $em->getRepository( 'VehiculosBundle:TipoVentaEspecial' )->find( $id );
			$return   = $entities->getMuestraPlanDeAhorro();
		}

		return new JsonResponse( $return );
	}
}
