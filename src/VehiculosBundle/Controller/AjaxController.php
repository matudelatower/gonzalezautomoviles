<?php

namespace VehiculosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AjaxController extends Controller {

    public function getMuestraCamposPlanDeAhorroAction(Request $request) {


        $id = $request->query->get('id');

        if (!$id) {
            $return = false;
        } else {

            $em = $this->getDoctrine()->getManager();
            $entities = $em->getRepository('VehiculosBundle:TipoVentaEspecial')->find($id);
            $return = $entities->getMuestraPlanDeAhorro();
        }

        return new JsonResponse($return);
    }

    public function movimientoDepositoNewAjaxAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $datos = $request->get('vehiculosbundle_movimientodeposito');

        $vehiculo = $em->getRepository('VehiculosBundle:Vehiculo')->find($request->get('id_vehiculo'));


        $entity = new \VehiculosBundle\Entity\MovimientoDeposito();


        $entity->setVehiculo($vehiculo);
        $deposito_destino = $em->getRepository('VehiculosBundle:Deposito')->find($datos['depositoDestino']);
        $entity->setDepositoDestino($deposito_destino);
        $entity->setFila($datos['fila']);
        $entity->setPosicion($datos['posicion']);
        $entity->setFechaIngreso(new \DateTime("now"));
        $entity->setActual('true');
        $entity->setObservacion($datos['observacion']);

        $em->persist($entity);
        $em->flush();     
        
        return new JsonResponse( 'true' );
        
    }

}
