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

	public function movimientoDepositoCreateAjaxAction( Request $request ) {
		$em     = $this->getDoctrine()->getManager();
		$entity = new \VehiculosBundle\Entity\MovimientoDeposito();
		$form   = $this->createForm( new \VehiculosBundle\Form\MovimientoDepositoType(), $entity );
		$form->handleRequest( $request );
		if ( $form->isValid() ) {
			$em->persist( $entity );
			$em->flush();

			return new JsonResponse( true );
		}

		return new JsonResponse( false, 400 );
	}

	public function newMovimientoDepositoAction( $vehiculoId ) {
		$entity   = new \VehiculosBundle\Entity\MovimientoDeposito();
		$vehiculo = $this->getDoctrine()->getManager()->getRepository( "VehiculosBundle:Vehiculo" )->find( $vehiculoId );
		$entity->setVehiculo( $vehiculo );
		$entity->setFechaIngreso( new \DateTime( "now" ) );
		$form = $this->createForm( new \VehiculosBundle\Form\MovimientoDepositoType(), $entity );

        $html = $this->renderView(
                'VehiculosBundle:Vehiculo:newMovimientoDeposito.html.twig', array(
            'form' => $form->createView(),
                )
        );
        return new JsonResponse($html);
    }

	public function getFotosDaniosGmAction( Request $request ) {


		$danioId = $request->query->get( 'danioId' );

		if ( ! $danioId ) {
			$entities = false;
		} else {

			$em       = $this->getDoctrine()->getManager();
			$entities = $em->getRepository( 'VehiculosBundle:FotoDanioGm' )->findByDanioVehiculo( $danioId );
			$html     = $this->renderView(
				'VehiculosBundle:Vehiculo:formFotoDanioGm.html.twig',
				array(
					'entity' => $entities,
				)
			);
		}

		return new JsonResponse( $html );
	}

	public function getTipoDanioInternoAction( Request $request ) {
		$categoriaId = $request->get( 'categoria_id' );
		$em        = $this->getDoctrine()->getManager();
		$categoria   = $em->getRepository( "VehiculosBundle:CategoriaDanioInterno" )->find( $categoriaId );

		$tipoDanios = $em->getRepository( "VehiculosBundle:TipoDanioInterno" )->findByCategoriaDanioInterno( $categoria );

		return $this->render( 'VehiculosBundle:Default:tipoDaniosInternos.html.twig',
			array(
				'tipoDanios' => $tipoDanios,
			) );

	}

}
