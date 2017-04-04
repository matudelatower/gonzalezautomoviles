<?php

namespace CRMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AjaxController extends Controller {
	public function getEncuestasAction( Request $request ) {

		$id = $request->get( 'id' );

		$criteria  = array( 'activo' => true );
		$encuestas = $this->getDoctrine()->getRepository( 'CRMBundle:Encuesta' )->findBy( $criteria );

		return $this->render( 'CRMBundle:Ajax:encuestas.html.twig',
			array(
				'encuestas' => $encuestas,
				'id' => $id
			) );
	}
}
