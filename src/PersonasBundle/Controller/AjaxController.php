<?php

namespace PersonasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AjaxController extends Controller {
    
	public function getEmpleadoByApellidoAction( Request $request ) {

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

			foreach ( $resultados as $empleado ) {

//				$retorno[] = array(
//					'id'    => $persona['id'],
//					'label' => sprintf( '%s, %s %s ID: %d',
//						$persona['apellido'],
//						$persona['nombre'],
//						$persona['otroNombre'],
//						$persona['id'] ),
//					'value' => sprintf( '%s, %s %s', $persona['apellido'], $persona['nombre'], $persona['otroNombre'] )
//				);

				$apellido  = $empleado->getPersonaTipo()->first()->getPersona()->getApellido();
				$nombre    = $empleado->getPersonaTipo()->first()->getPersona()->getNombre();
				$retorno[] = array(
					'id'    => $empleado->getId(),
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
