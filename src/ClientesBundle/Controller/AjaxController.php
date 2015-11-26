<?php

namespace ClientesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AjaxController extends Controller {
	public function getClienteByDniAction( Request $request ) {

		$personaCriteria = trim( $request->get( 'term' ) );
		$searchMethod    = $request->get( 'search_method' );

//		$getProperty = ucwords( trim( $request->get( 'search_method' ) ) );
		$em = $this->getDoctrine()->getManagerForClass( $request->get( 'class' ) );

		$resultados = $em->getRepository( $request->get( 'class' ) )->$searchMethod( $personaCriteria );

		$retorno = array();

		if ( ! count( $resultados ) ) {
			$retorno[] = array(
				'label' => 'No se encontraron coincidencias',
				'value' => ''
			);
		} else {

			foreach ( $resultados as $cliente ) {

//				$retorno[] = array(
//					'id'    => $persona['id'],
//					'label' => sprintf( '%s, %s %s ID: %d',
//						$persona['apellido'],
//						$persona['nombre'],
//						$persona['otroNombre'],
//						$persona['id'] ),
//					'value' => sprintf( '%s, %s %s', $persona['apellido'], $persona['nombre'], $persona['otroNombre'] )
//				);

				$apellido  = $cliente->getPersonaTipo()->first()->getPersona()->getApellido();
				$nombre    = $cliente->getPersonaTipo()->first()->getPersona()->getNombre();
				$retorno[] = array(
					'id'    => $cliente->getId(),
					'label' => sprintf( '%s, %s',
						$apellido,
						$nombre
					),
					'value' => sprintf( '%s, %s', $apellido, $nombre )
				);
			}
		}

//		$retorno = json_encode( $retorno );
//
//		return new Response( $retorno, 200, array( 'Content-Type' => 'application/json' ) );
		return new JsonResponse( $retorno );

	}
}
