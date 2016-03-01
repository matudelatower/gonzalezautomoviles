<?php

namespace VehiculosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AjaxController extends Controller {

    public function getMuestraCamposPlanDeAhorroAction(Request $request) {


        $id = $request->query->get('id');

        if (!$id) {
            $return['muestra_plan_ahorro'] = false;
        } else {

            $em = $this->getDoctrine()->getManager();
            $entities = $em->getRepository('VehiculosBundle:TipoVentaEspecial')->find($id);
            $return['muestra_plan_ahorro'] = $entities->getMuestraPlanDeAhorro();
            $return['slug'] = $entities->getSlug();
        }

        return new JsonResponse($return);
    }

    public function newMovimientoDepositoAction($vehiculoId) {
        $entity = new \VehiculosBundle\Entity\MovimientoDeposito();
        $vehiculo = $this->getDoctrine()->getManager()->getRepository("VehiculosBundle:Vehiculo")->find($vehiculoId);
        $entity->setVehiculo($vehiculo);
        $entity->setFechaIngreso(new \DateTime("now"));
        $form = $this->createForm(new \VehiculosBundle\Form\MovimientoDepositoType(), $entity);

        $html = $this->renderView(
                'VehiculosBundle:Vehiculo:newMovimientoDeposito.html.twig', array(
            'form' => $form->createView(),
                )
        );
        return new JsonResponse($html);
    }

    public function movimientoDepositoCreateAjaxAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $entity = new \VehiculosBundle\Entity\MovimientoDeposito();
        $form = $this->createForm(new \VehiculosBundle\Form\MovimientoDepositoType(), $entity);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            return new JsonResponse(true);
        }

        return new JsonResponse(false, 400);
    }

    /*
     * Crea un modal para registrar el pago de un vehiculo a GM
     */

    public function newRegistroPagoAGmAjaxAction($vehiculoId) {
        $vehiculo = $this->getDoctrine()->getManager()->getRepository("VehiculosBundle:Vehiculo")->find($vehiculoId);
        $html = $this->renderView(
                'VehiculosBundle:Vehiculo:newRegistroPagoAGm.html.twig', array(
            'vehiculo' => $vehiculo,
                )
        );
        return new JsonResponse($html);
    }

    /*
     * Registra que el vehiculo fue pagado a gm. cambia estado pagado a true
     */

    public function pagoAGmUpdateAjaxAction($vehiculoId) {
        $em = $this->getDoctrine()->getManager();
        $vehiculo = $this->getDoctrine()->getManager()->getRepository("VehiculosBundle:Vehiculo")->find($vehiculoId);
        $vehiculo->setPagado(true);
        $em->persist($vehiculo);
        $em->flush();
        return new JsonResponse(true);
    }

    /*
     * Crea un modal para asignar el vehiculo a un cliente que puede ser o no un reventa
     */

    public function newAsignacionVehiculoAjaxAction($vehiculoId) {
        $vehiculo = $this->getDoctrine()->getManager()->getRepository("VehiculosBundle:Vehiculo")->find($vehiculoId);

        $form = $this->createForm(new \VehiculosBundle\Form\AsignacionVehiculoType(), $vehiculo);

        $html = $this->renderView(
                'VehiculosBundle:Vehiculo:newAsignacionVehiculo.html.twig', array(
            'form' => $form->createView(),
            'vehiculo' => $vehiculo,
                )
        );
        return new JsonResponse($html);
    }

    /*
     * Registra que se asigna a un cliente un vehiculo
     */

    public function asignacionVehiculoUpdateAjaxAction(Request $request, $vehiculoId) {
        $em = $this->getDoctrine()->getManager();
        $vehiculo = $this->getDoctrine()->getManager()->getRepository("VehiculosBundle:Vehiculo")->find($vehiculoId);
        $prueba = $request->request->get('vehiculosbundle_asignacion_vehiculo');
        $cliente = $this->getDoctrine()->getManager()->getRepository("ClientesBundle:Cliente")->find($prueba['cliente']);
        $vehiculo->setCliente($cliente);
        $em->persist($vehiculo);
        $em->flush();

        return new JsonResponse(true);
    }

    /*
     * Crea un modal para guardar cupon de garantia
     */

    public function newCuponGarantiaAjaxAction($vehiculoId) {
        $vehiculo = $this->getDoctrine()->getManager()->getRepository("VehiculosBundle:Vehiculo")->find($vehiculoId);

        $form = $this->createForm(new \VehiculosBundle\Form\CuponGarantiaVehiculoType(), $vehiculo);

        $html = $this->renderView(
                'VehiculosBundle:Vehiculo:newCuponGarantiaVehiculo.html.twig', array(
            'form' => $form->createView(),
            'vehiculo' => $vehiculo,
                )
        );
        return new JsonResponse($html);
    }
    
    /*
     * Registra que se asigna a un cliente un vehiculo
     */

    public function cuponGarantiaUpdateAjaxAction(Request $request, $vehiculoId) {
        $em = $this->getDoctrine()->getManager();
        $vehiculo = $this->getDoctrine()->getManager()->getRepository("VehiculosBundle:Vehiculo")->find($vehiculoId);
//        $prueba = $request->request->get('vehiculosbundle_asignacion_vehiculo');
//        $cliente = $this->getDoctrine()->getManager()->getRepository("ClientesBundle:Cliente")->find($prueba['cliente']);
        
        $form = $this->createForm(new \VehiculosBundle\Form\CuponGarantiaVehiculoType(), $vehiculo);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($vehiculo);
            $em->flush();
            return new JsonResponse(true);
        } else {
            return new JsonResponse(false);
        }
    }
    
    
    /**
     * @param Request $request
     * @param $vehiculoId el ide del vehiculo
     *
     * @return JsonResponse true si la operacion se realiza con exito
     */
    public function desasignacionVehiculoUpdateAjaxAction( Request $request, $vehiculoId ) {
        $em       = $this->getDoctrine()->getManager();
        $vehiculo = $this->getDoctrine()->getManager()->getRepository( "VehiculosBundle:Vehiculo" )->find( $vehiculoId );

        $vehiculo->setCliente( null );
        $em->persist( $vehiculo );
        $em->flush();

        return new JsonResponse( true );
    }

    /*
     * Crea un modal para registrar la fecha de entrega del vehiculo
     */

    public function newAgendaEntregaAjaxAction($vehiculoId) {
        $vehiculo = $this->getDoctrine()->getManager()->getRepository("VehiculosBundle:Vehiculo")->find($vehiculoId);
        $agendaEntrega = $this->getDoctrine()->getManager()->getRepository("VehiculosBundle:AgendaEntrega")->findOneByVehiculo($vehiculo);
        if (!$agendaEntrega) {
            $agendaEntrega = new \VehiculosBundle\Entity\AgendaEntrega();
        }
        $agendaEntrega->setVehiculo($vehiculo);
        $form = $this->createForm(new \VehiculosBundle\Form\AgendaEntregaType, $agendaEntrega);

        $html = $this->renderView(
                'VehiculosBundle:AgendaEntrega:new.html.twig', array(
            'form' => $form->createView(),
            'vehiculoId' => $vehiculoId
                )
        );
        return new JsonResponse($html);
    }

    /*
     * guarda los datos de la entrega de un vehiculo
     */

    public function AgendaEntregaCreateAjaxAction(Request $request, $vehiculoId) {
        $em = $this->getDoctrine()->getManager();
        $agendaEntrega = $em->getRepository('VehiculosBundle:AgendaEntrega')->findOneByVehiculo($vehiculoId);
        if (!$agendaEntrega) {
            $agendaEntrega = new \VehiculosBundle\Entity\AgendaEntrega();
        }
        $form = $this->createForm(new \VehiculosBundle\Form\AgendaEntregaType, $agendaEntrega);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($agendaEntrega);
            $em->flush();
            return new JsonResponse(true);
        } else {
            return new JsonResponse(false);
        }
    }

    public function getFotosDaniosGmAction(Request $request) {


        $danioId = $request->query->get('danioId');

        if (!$danioId) {
            $entities = false;
        } else {

            $em = $this->getDoctrine()->getManager();
            $entities = $em->getRepository('VehiculosBundle:FotoDanioGm')->findByDanioVehiculo($danioId);
            $html = $this->renderView(
                    'VehiculosBundle:Vehiculo:formFotoDanioGm.html.twig', array(
                'entity' => $entities,
                    )
            );
        }

        return new JsonResponse($html);
    }

    public function getFotosDaniosInternoAction(Request $request) {


        $danioId = $request->query->get('danioId');

        if (!$danioId) {
            $entities = false;
        } else {

            $em = $this->getDoctrine()->getManager();
            $entities = $em->getRepository('VehiculosBundle:FotoDanioInterno')->findByDanioVehiculoInterno($danioId);
            $html = $this->renderView(
                    'VehiculosBundle:Vehiculo:formFotoDanioInterno.html.twig', array(
                'entity' => $entities,
                    )
            );
        }

        return new JsonResponse($html);
    }

    public function getTipoDanioInternoAction(Request $request) {
        $categoriaId = $request->get('categoria_id');
        $em = $this->getDoctrine()->getManager();
        $categoria = $em->getRepository("VehiculosBundle:CategoriaDanioInterno")->find($categoriaId);

        $tipoDanios = $em->getRepository("VehiculosBundle:TipoDanioInterno")->findByCategoriaDanioInterno($categoria);

        return $this->render('VehiculosBundle:Default:tipoDaniosInternos.html.twig', array(
                    'tipoDanios' => $tipoDanios,
        ));
    }

    public function getSlugEstadoPatentamientoAction(Request $request) {
        $id = $request->query->get('id');

        if (!$id) {
            $return = false;
        } else {

            $em = $this->getDoctrine()->getManager();
            $entities = $em->getRepository('VehiculosBundle:EstadoPatentamiento')->find($id);
            $return = $entities->getSlug();
        }

        return new JsonResponse($return);
    }

}
