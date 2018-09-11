<?php

namespace VehiculosBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UsuariosBundle\Controller\TokenAuthenticatedController;
use VehiculosBundle\Entity\EstadoVehiculo;
use VehiculosBundle\Entity\Vehiculo;
use VehiculosBundle\Entity\Patentamiento;
use VehiculosBundle\Form\AltaVehiculoType;
use VehiculosBundle\Form\FacturaVehiculoType;
use VehiculosBundle\Form\CheckListPreEntregaType;
use VehiculosBundle\Form\EditarVehiculoType;
use VehiculosBundle\Form\VehiculoType;
use VehiculosBundle\Form\VehiculoFilterType;
use VehiculosBundle\Form\PatentamientoType;

/**
 * Vehiculo controller.
 *
 */
class VehiculoController extends Controller implements TokenAuthenticatedController {

    /**
     * Lists all Vehiculo entities.
     *
     */
    public function indexAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new VehiculoFilterType($em));
        if ($request->isMethod("post")) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosEstado(false, $data);
            }
        } else {
            $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosEstado(false);
        }
        $cantidadRegistros = count($entities);
//        $formMovimientoDeposito = $this->createForm(new \VehiculosBundle\Form\MovimientoDepositoType());
        $paginator = $this->get('knp_paginator');
        if ($request->request->get('vehiculosbundle_vehiculo_filter')['registrosPaginador'] != "") {
            $limit = $request->request->get('vehiculosbundle_vehiculo_filter')['registrosPaginador'];
        } else {
            $limit = 10;
        }
        $entities = $paginator->paginate(
                $entities, $request->query->get('page', 1)/* page number */, $limit/* limit per page */
        );

        return $this->render(
                        'VehiculosBundle:Vehiculo:index.html.twig', array(
                    'entities' => $entities,
                    'form' => $form->createView(),
//                    'form_movimiento_deposito' => $formMovimientoDeposito->createView(),
                    'cantidadRegistros' => $cantidadRegistros,
                    'muestraFiltroEstado' => true,
                    'muestraFiltroPlanAhorro' => true,
                        )
        );
    }

    /**
     * listado de vehiculos que se encuentren en transito por recibir.
     *
     */
    public function vehiculosTransitoIndexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $estado = $em->getRepository('VehiculosBundle:TipoEstadoVehiculo')->findBySlug('transito');
        $form = $this->createForm(new VehiculoFilterType($em));

        if ($request->isMethod("post")) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                if ($data['rango']) {
                    $aFecha = explode(' - ', $data['rango']);

                    $fechaDesde = \DateTime::createFromFormat('d/m/Y', $aFecha[0]);
                    $fechaHasta = \DateTime::createFromFormat('d/m/Y', $aFecha[1]);

                    $data['fechaDesde'] = $fechaDesde->format('Y-m-d') . ' 00:00:00';
                    $data['fechaHasta'] = $fechaHasta->format('Y-m-d') . ' 23:59:59';
                }
                $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosEstado($estado, $data);
            }
        } else {
            $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosEstado($estado);
        }
        $cantidadRegistros = count($entities);

        $paginator = $this->get('knp_paginator');
        if ($request->request->get('vehiculosbundle_vehiculo_filter')['registrosPaginador'] != "") {
            $limit = $request->request->get('vehiculosbundle_vehiculo_filter')['registrosPaginador'];
        } else {
            $limit = 10;
        }
        $entities = $paginator->paginate(
                $entities, $request->query->get('page', 1)/* page number */, $limit/* limit per page */
        );

        return $this->render(
                        'VehiculosBundle:Vehiculo:transitoIndex.html.twig', array(
                    'entities' => $entities,
                    'form' => $form->createView(),
                    'cantidadRegistros' => $cantidadRegistros,
                    'muestraRangoFecha' => true,
                    'labelRangoFecha' => 'Fecha remito',
                        )
        );
    }

    /**
     * listado de vehiculos que se recibieron ya sea conforme o con daños.
     *
     */
    public function vehiculosRecibidosIndexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $estadoId1 = $em->getRepository('VehiculosBundle:TipoEstadoVehiculo')->findOneBySlug('recibido');
        $estados = array($estadoId1);
        $form = $this->createForm(new VehiculoFilterType($em));
        if ($request->isMethod("post")) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                if ($data['rango']) {
                    $aFecha = explode(' - ', $data['rango']);

                    $fechaDesde = \DateTime::createFromFormat('d/m/Y', $aFecha[0]);
                    $fechaHasta = \DateTime::createFromFormat('d/m/Y', $aFecha[1]);

                    $data['fechaDesde'] = $fechaDesde->format('Y-m-d') . ' 00:00:00';
                    $data['fechaHasta'] = $fechaHasta->format('Y-m-d') . ' 23:59:59';
                }
                $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosEstado($estados, $data);
            }
        } else {
            $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosEstado($estados);
        }
        $cantidadRegistros = count($entities);
//        $formMovimientoDeposito = $this->createForm(new \VehiculosBundle\Form\MovimientoDepositoType());

        $paginator = $this->get('knp_paginator');
        if ($request->request->get('vehiculosbundle_vehiculo_filter')['registrosPaginador'] != "") {
            $limit = $request->request->get('vehiculosbundle_vehiculo_filter')['registrosPaginador'];
        } else {
            $limit = 10;
        }
        $entities = $paginator->paginate(
                $entities, $request->query->get('page', 1)/* page number */, $limit/* limit per page */
        );
        return $this->render(
                        'VehiculosBundle:Vehiculo:recibidosIndex.html.twig', array(
                    'entities' => $entities,
                    'form' => $form->createView(),
//                    'form_movimiento_deposito' => $formMovimientoDeposito->createView(),
                    'cantidadRegistros' => $cantidadRegistros,
                    'muestraRangoFecha' => true,
                    'labelRangoFecha' => 'Fecha recibido',
                        )
        );
    }

    /**
     * listado de vehiculos que se encuentran es stock, asignados a cliente o reventa.
     *
     */
    public function vehiculosStockIndexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new VehiculoFilterType($em));
        $estadoId1 = $em->getRepository('VehiculosBundle:TipoEstadoVehiculo')->findOneBySlug('stock');
        $estados = array($estadoId1);

        if ($request->isMethod("post")) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                if ($data['rango']) {
                    $aFecha = explode(' - ', $data['rango']);

                    $fechaDesde = \DateTime::createFromFormat('d/m/Y', $aFecha[0]);
                    $fechaHasta = \DateTime::createFromFormat('d/m/Y', $aFecha[1]);

                    $data['fechaDesde'] = $fechaDesde->format('Y-m-d') . ' 00:00:00';
                    $data['fechaHasta'] = $fechaHasta->format('Y-m-d') . ' 23:59:59';
                }
                $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosEstado($estados, $data);
            }
        } else {
            $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosEstado($estados);
        }
        $cantidadRegistros = count($entities);

//        $formMovimientoDeposito = $this->createForm(new \VehiculosBundle\Form\MovimientoDepositoType());


        $paginator = $this->get('knp_paginator');
        if ($request->request->get('vehiculosbundle_vehiculo_filter')['registrosPaginador'] != "") {
            $limit = $request->request->get('vehiculosbundle_vehiculo_filter')['registrosPaginador'];
        } else {
            $limit = 10;
        }
        $entities = $paginator->paginate(
                $entities, $request->query->get('page', 1)/* page number */, $limit/* limit per page */
        );

        return $this->render(
                        'VehiculosBundle:Vehiculo:stockIndex.html.twig', array(
                    'entities' => $entities,
                    'form' => $form->createView(),
//                    'form_movimiento_deposito' => $formMovimientoDeposito->createView(),
                    'cantidadRegistros' => $cantidadRegistros,
                    'muestraRangoFecha' => true,
                    'labelRangoFecha' => 'Fecha pre-entrega',
                        )
        );
    }

    /**
     * listado de vehiculos que estan pendientes por entregar.
     *
     */
    public function vehiculosPendientesPorEntregarIndexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new VehiculoFilterType($em));
        $estadoId1 = $em->getRepository('VehiculosBundle:TipoEstadoVehiculo')->findOneBySlug('pendiente-por-entregar');
        $estados = array($estadoId1);

        $order = " fecha_entrega asc,hora_entrega asc,modelo_nombre asc,modelo_anio asc,color_vehiculo asc";
        if ($request->isMethod("post")) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosEstado($estados, $data, $order);
            }
        } else {
            $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosEstado($estados, null, $order);
        }
        $cantidadRegistros = count($entities);

//        $formMovimientoDeposito = $this->createForm(new \VehiculosBundle\Form\MovimientoDepositoType());

        $paginator = $this->get('knp_paginator');
        if ($request->request->get('vehiculosbundle_vehiculo_filter')['registrosPaginador'] != "") {
            $limit = $request->request->get('vehiculosbundle_vehiculo_filter')['registrosPaginador'];
        } else {
            $limit = 10;
        }
        $entities = $paginator->paginate(
                $entities, $request->query->get('page', 1)/* page number */, $limit/* limit per page */
        );

        return $this->render(
                        'VehiculosBundle:Vehiculo:pendientesPorEntregarIndex.html.twig', array(
                    'entities' => $entities,
                    'form' => $form->createView(),
//                    'form_movimiento_deposito' => $formMovimientoDeposito->createView(),
                    'cantidadRegistros' => $cantidadRegistros,
                        )
        );
    }

    /**
     * listado de vehiculos que fueron patentados.
     *
     */
    public function vehiculosEntregadosIndexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new VehiculoFilterType($em));
        $estadoId1 = $em->getRepository('VehiculosBundle:TipoEstadoVehiculo')->findOneBySlug('entregado');
        $estados = array($estadoId1);
        $order = " fecha_estado DESC, modelo_nombre ASC,color_vehiculo ASC, v.vin ASC";
        if ($request->isMethod("post")) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                if ($data['rango']) {
                    $aFecha = explode(' - ', $data['rango']);

                    $fechaDesde = \DateTime::createFromFormat('d/m/Y', $aFecha[0]);
                    $fechaHasta = \DateTime::createFromFormat('d/m/Y', $aFecha[1]);

                    $data['fechaDesde'] = $fechaDesde->format('Y-m-d') . ' 00:00:00';
                    $data['fechaHasta'] = $fechaHasta->format('Y-m-d') . ' 23:59:59';
                }
                $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosEstado($estados, $data, $order);
            }
        } else {
            $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosEstado($estados, null, $order);
        }
        $cantidadRegistros = count($entities);

        $paginator = $this->get('knp_paginator');
        if ($request->request->get('vehiculosbundle_vehiculo_filter')['registrosPaginador'] != "") {
            $limit = $request->request->get('vehiculosbundle_vehiculo_filter')['registrosPaginador'];
        } else {
            $limit = 10;
        }
        $entities = $paginator->paginate(
                $entities, $request->query->get('page', 1)/* page number */, $limit/* limit per page */
        );

        return $this->render(
                        'VehiculosBundle:Vehiculo:entregadosIndex.html.twig', array(
                    'entities' => $entities,
                    'form' => $form->createView(),
                    'cantidadRegistros' => $cantidadRegistros,
                    'muestraRangoFecha' => true,
                    'muestraFiltroReventa' => true,
                    'labelRangoFecha' => 'Fecha entregado',
                        )
        );
    }

    /**
     * Creates a new Vehiculo entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Vehiculo();
        $form = $this->createCreateForm($entity, new AltaVehiculoType());
        $form->handleRequest($request);

        if ($form->isValid()) {


            $em = $this->getDoctrine()->getManager();
            $tipoEstadoVehiculo = $em->getRepository('VehiculosBundle:TipoEstadoVehiculo')->findOneBySlug(
                    'transito'
            );

            $estadoVehiculo = new EstadoVehiculo();
            $estadoVehiculo->setTipoEstadoVehiculo($tipoEstadoVehiculo);
            $estadoVehiculo->setVehiculo($entity);
            $entity->addEstadoVehiculo($estadoVehiculo);

            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                    'success', 'Vehiculo creado correctamente.'
            );

            return $this->redirect($this->generateUrl('vehiculos_show', array('id' => $entity->getId())));
        }

        return $this->render(
                        'VehiculosBundle:Vehiculo:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                        )
        );
    }

    /**
     * Creates a form to create a Vehiculo entity.
     *
     * @param Vehiculo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Vehiculo $entity, $type = null, $route = null, $submitLabel = 'Crear') {

        if (!$type) {
            $type = new VehiculoType();
        }

        if (!$route) {
            $route = $this->generateUrl('vehiculos_create');
        }

        $form = $this->createForm(
                $type, $entity, array(
            'action' => $route,
            'method' => 'POST',
            'attr' => array('class' => 'box-body')
                )
        );

        $form->add(
                'submit', 'submit', array(
            'label' => $submitLabel,
            'attr' => array('class' => 'btn btn-primary pull-right')
                )
        );

        return $form;
    }

    /**
     * Displays a form to create a new Vehiculo entity.
     *
     */
    public function newAction() {
        $entity = new Vehiculo();
        $form = $this->createCreateForm($entity);

        return $this->render(
                        'VehiculosBundle:Vehiculo:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                        )
        );
    }

    /**
     * Finds and displays a Vehiculo entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:Vehiculo')->find($id);
        $encuestaResultadoCabecera = $em->getRepository('CuestionariosBundle:EncuestaResultadoCabecera')->findOneByVehiculo($entity);
        $controlInternoCabecera = $em->getRepository('VehiculosBundle:CheckControlInternoResultadoCabecera')->findOneByVehiculo($entity);
        $checklistPreEntrega = $em->getRepository('CuestionariosBundle:CuestionarioResultadoCabecera')->findOneByVehiculo($entity);


	    //CRM encuestas
	    $slug = 'venta';
        $encuesta = $em->getRepository('CRMBundle:Encuesta')->findBySlug($slug);
        $criteriaPostVenta= [
        	'vehiculo'=>$entity,
        	'encuesta'=>$encuesta
        ];
        $encuestaPostVenta = $em->getRepository('CRMBundle:EncuestaResultadoCabecera')->findOneBy($criteriaPostVenta);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vehiculo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        //si tiene faactura creamos el form como para poder eliminarla
        if ($entity->getFactura()) {
            $deletefacturaForm = $this->createDeleteFacturaForm($id);
        } else {
            $deletefacturaForm = null;
        }

        return $this->render(
                        'VehiculosBundle:Vehiculo:show.html.twig', array(
                    'entity' => $entity,
                    'encuestaResultadoCabecera' => $encuestaResultadoCabecera,
                    'controlInternoCabecera' => $controlInternoCabecera,
                    'checklistPreEntrega' => $checklistPreEntrega,
                    'encuestaPostVenta' => $encuestaPostVenta,
                    'slug' => $slug,
                    'delete_form' => $deleteForm->createView(),
                    'delete_factura_form' => ($deletefacturaForm) ? $deletefacturaForm->createView() : null,
                        )
        );
    }

    /**
     * Displays a form to edit an existing Vehiculo entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:Vehiculo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vehiculo entity.');
        }

        $editForm = $this->createEditForm($entity);

//		$deleteForm = $this->createDeleteForm( $id );

        return $this->render(
                        'VehiculosBundle:Vehiculo:editarVehiculoPendiente.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
//				'delete_form' => $deleteForm->createView(),
                        )
        );
    }

    /**
     * Creates a form to edit a Vehiculo entity.
     *
     * @param Vehiculo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Vehiculo $entity) {
        $form = $this->createForm(
                new AltaVehiculoType("edit"), $entity, array(
            'action' => $this->generateUrl('vehiculos_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            'attr' => array('class' => 'box-body')
                )
        );

        $form->add(
                'submit', 'submit', array(
            'label' => 'Actualizar',
            'attr' => array('class' => 'btn btn-primary pull-right'),
                )
        );

        return $form;
    }

    /**
     * Creates a form to crear a Patentamiento entity.
     *
     * @param Patentamiento $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createPatentamientoForm(Patentamiento $entity, $route, $submitLabel = 'Guardar') {


        $type = new PatentamientoType();


        $form = $this->createForm(
                $type, $entity, array(
            'action' => $route,
            'method' => 'POST',
            'attr' => array('class' => 'box-body')
                )
        );

        $form->add(
                'submit', 'submit', array(
            'label' => $submitLabel,
            'attr' => array('class' => 'btn btn-primary pull-right')
                )
        );

        return $form;
    }

    /**
     * Crea form para guardar una factura para el vehiculo
     * @return type
     */
    public function newFacturaAction($vehiculoId) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:Vehiculo')->find($vehiculoId);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vehiculo entity.');
        }

        $form = $this->createCreateForm($entity, new FacturaVehiculoType(), $this->generateUrl('vehiculos_create_factura', array('vehiculoId' => $vehiculoId)), 'Guardar');

        return $this->render(
                        'VehiculosBundle:Vehiculo:newFactura.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                        )
        );
    }

    /**
     * Crea o actualiza una factura para un automovil.
     *
     */
    public function vehiculosCreateFacturaAction(Request $request, $vehiculoId) {
        $em = $this->getDoctrine()->getManager();
        $vehiculo = $em->getRepository('VehiculosBundle:Vehiculo')->find($vehiculoId);

        if (!$vehiculo) {
            throw $this->createNotFoundException('Unable to find Vehiculo entity.');
        }

        $form = $this->createCreateForm($vehiculo, new FacturaVehiculoType(), $this->generateUrl('vehiculos_create_factura', array('vehiculoId' => $vehiculoId)), 'Guardar');

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $controlInternoCabecera = $em->getRepository('VehiculosBundle:CheckControlInternoResultadoCabecera')->findOneByVehiculo($vehiculo);
                if (!$controlInternoCabecera) {
                    $tipoEstadoVehiculo = $em->getRepository('VehiculosBundle:TipoEstadoVehiculo')->findOneBySlug(
                            'pendiente-por-entregar'
                    );
                } else {
                    //di tiene $controlInternoCabecera significa que se hizo el check de control interno
                    //por ende pasa a estado estregado
                    $tipoEstadoVehiculo = $em->getRepository('VehiculosBundle:TipoEstadoVehiculo')->findOneBySlug(
                            'entregado'
                    );
                }

                //controlo que el vehiculo ya no este en el estado al que queremos pasar, esto es en caso de
                //que el vehiculo haya pasado a entregado sin facturar
                if ($vehiculo->getEstadoVehiculo()->last()->getTipoEstadoVehiculo() !== $tipoEstadoVehiculo) {
                    $estadoVehiculo = new EstadoVehiculo();
                    $estadoVehiculo->setTipoEstadoVehiculo($tipoEstadoVehiculo);
                    $estadoVehiculo->setVehiculo($vehiculo);
                    $vehiculo->addEstadoVehiculo($estadoVehiculo);
                }

                $em->flush();

                $this->get('session')->getFlashBag()->add(
                        'success', 'Factura guardada correctamente.'
                );

//                return $this->redirect($this->generateUrl('vehiculos_create_factura', array('vehiculoId' => $vehiculoId)));
            } else {
                $this->get('session')->getFlashBag()->add(
                        'error', 'Hubo un problema al guardar la factura.'
                );
            }
        }
        return $this->render(
                        'VehiculosBundle:Vehiculo:newFactura.html.twig', array(
                    'entity' => $vehiculo,
                    'form' => $form->createView(),
                        )
        );
    }

    /**
     * Crea form para guardar datos de patentamiento de un vehiculo
     * @return type
     */
    public function editPatenteAction($vehiculoId) {
        $em = $this->getDoctrine()->getManager();

        $vehiculo = $em->getRepository('VehiculosBundle:Vehiculo')->find($vehiculoId);
        if ($vehiculo->getPatentamiento()) {
            $entity = $em->getRepository('VehiculosBundle:Patentamiento')->find($vehiculo->getPatentamiento()->getId());
        } else {
            $entity = new Patentamiento();
        }

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vehiculo entity.');
        }

        $form = $this->createPatentamientoForm($entity, $this->generateUrl('vehiculos_update_patente', array('vehiculoId' => $vehiculoId)));

        return $this->render(
                        'VehiculosBundle:Vehiculo:editPatente.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                        )
        );
    }

    /**
     * Crea o actualiza una factura para un automovil.
     *
     */
    public function vehiculosUpdatePatenteAction(Request $request, $vehiculoId) {
        $em = $this->getDoctrine()->getManager();
        $vehiculo = $em->getRepository('VehiculosBundle:Vehiculo')->find($vehiculoId);
        if ($vehiculo->getPatentamiento()) {
            $entity = $em->getRepository('VehiculosBundle:Patentamiento')->find($vehiculo->getPatentamiento()->getId());
        } else {
            $entity = new Patentamiento();
        }

        $form = $this->createPatentamientoForm($entity, $this->generateUrl('vehiculos_update_patente', array('vehiculoId' => $vehiculoId)));

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em->persist($entity);
                $vehiculo->setPatentamiento($entity);
//                $data = $form->getData();
//                if ($data->getEstadoPatentamiento()->getSlug() == 'patentado') {
//                    $tipoEstadoVehiculo = $em->getRepository('VehiculosBundle:TipoEstadoVehiculo')->findOneBySlug(
//                            'patentado'
//                    );
//                    $estadoVehiculo = new EstadoVehiculo();
//                    $estadoVehiculo->setTipoEstadoVehiculo($tipoEstadoVehiculo);
//                    $estadoVehiculo->setVehiculo($vehiculo);
//                    $vehiculo->addEstadoVehiculo($estadoVehiculo);
//                }

                $em->flush();

                $this->get('session')->getFlashBag()->add(
                        'success', 'Patente guardada correctamente.'
                );

//                return $this->redirect($this->generateUrl('vehiculos_create_factura', array('vehiculoId' => $vehiculoId)));
            } else {
                $this->get('session')->getFlashBag()->add(
                        'error', 'Hubo un problema al guardar los datos de la patente.'
                );
            }
        }
        return $this->render(
                        'VehiculosBundle:Vehiculo:editPatente.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                        )
        );
    }

    /**
     * Edits an existing Vehiculo entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:Vehiculo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vehiculo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                    'success', 'Vehiculo actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('vehiculos_edit', array('id' => $id)));
        }

        return $this->render(
                        'VehiculosBundle:Vehiculo:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                        )
        );
    }

    /**
     * Deletes a Vehiculo entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VehiculosBundle:Vehiculo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Vehiculo entity.');
            }

            //consulto si tiene hecho el check de control interno y lo elimino
            $checkControlInterno = $em->getRepository('VehiculosBundle:CheckControlInternoResultadoCabecera')->findOneByVehiculo($entity);
            if ($checkControlInterno) {
                $em->remove($checkControlInterno);
            }

            //elimino el vehiculo
            $em->remove($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                    'success', 'Vehiculo eliminado correctamente.'
            );
        }

        return $this->redirect($this->generateUrl('vehiculos'));
    }

    /**
     * Creates a form to delete a Vehiculo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('vehiculos_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Eliminar vehiculo',
                            'attr' => array(
                                'class' => 'btn btn-danger',
                                'onclick' => 'return confirm("Al eliminar el vehiculo se perderan todos los datos del mismo y no los podra recuperar, desea eliminar de todas formas?")')))
                        ->getForm();
    }

    public function altaAction() {
        $entity = new Vehiculo();
        $form = $this->createCreateForm($entity, new AltaVehiculoType());

        return $this->render(
                        'VehiculosBundle:Vehiculo:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                        )
        );
    }

    public function actualizarVehiculoRemitoAction(Request $request, $vehiculoId) {
        $em = $this->getDoctrine()->getManager();
        $vehiculo = $em->getRepository('VehiculosBundle:Vehiculo')->find($vehiculoId);
        $ruta = $this->generateUrl('vehiculos_actualizar_remito', array('vehiculoId' => $vehiculoId));

        $daniosGmOriginal = new ArrayCollection();

        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($vehiculo->getDanioVehiculoGm() as $danioGm) {
            $daniosGmOriginal->add($danioGm);
        }

        $form = $this->createCreateForm($vehiculo, new EditarVehiculoType(), $ruta, 'Actualizar');

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $vehiculosManager = $this->get('manager.vehiculos');

                $tipoEstadoDanioGm = $em->getRepository('VehiculosBundle:TipoEstadoDanioGm')->findOneBySlug(
                        'registrado'
                );

                if ($vehiculosManager->guardarVehiculo($vehiculo, $tipoEstadoDanioGm, $daniosGmOriginal)) {

                    $this->get('session')->getFlashBag()->add(
                            'success', 'Datos del Vehiculo actualizados correctamente.'
                    );
                }
            }
        }

        return $this->render('VehiculosBundle:Vehiculo:edit.html.twig', array(
                    'edit_form' => $form->createView(),
        ));
    }

    public function editarVehiculoRecibidoAction(Request $request, $vehiculoId) {
        $em = $this->getDoctrine()->getManager();
        $vehiculo = $em->getRepository('VehiculosBundle:Vehiculo')->find($vehiculoId);
        $ruta = $this->generateUrl('vehiculos_editar_recibido', array('vehiculoId' => $vehiculoId));


        $form = $this->createCreateForm($vehiculo, new EditarVehiculoType(), $ruta, 'Actualizar');


        $daniosGmOriginal = new ArrayCollection();

        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($vehiculo->getDanioVehiculoGm() as $danioGm) {
            $daniosGmOriginal->add($danioGm);
        }

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $vehiculosManager = $this->get('manager.vehiculos');

                if ($vehiculosManager->guardarVehiculo($vehiculo, null, $daniosGmOriginal, $operacion = "editar")) {

                    $this->get('session')->getFlashBag()->add(
                            'success', 'Datos del Vehiculo actualizados correctamente.'
                    );
                }
            }
        }

        return $this->render('VehiculosBundle:Vehiculo:editarVehiculoRecibido.html.twig', array(
                    'vehiculo' => $vehiculo,
                    'edit_form' => $form->createView(),
        ));
    }

    public function checklistPreEntregaAction(Request $request, $vehiculoId) {
        $em = $this->getDoctrine()->getManager();

        $vehiculo = $em->getRepository('VehiculosBundle:Vehiculo')->find($vehiculoId);

        $cuestionario = $em->getRepository('CuestionariosBundle:Cuestionario')->find(1);


        $categorias = $em->getRepository('CuestionariosBundle:CuestionarioCategoria')->getCategoriasConCampos(
                $cuestionario
        );

        $daniosInternos = new ArrayCollection();

        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($vehiculo->getDanioVehiculoInterno() as $danioInterno) {
            $daniosInternos->add($danioInterno);
        }

        $formDaniosInternos = $this->createForm(new CheckListPreEntregaType(), $vehiculo);


        if (!$categorias) {
            throw $this->createNotFoundException('No se encuentra el Campo');
        }

        if ($request->getMethod() == 'POST') {
            $formDaniosInternos->handleRequest($request);
            if ($formDaniosInternos->isValid()) {
                $checkList = $request->get('cuestionarios_bundle_check_list_parameter_type');

                $vehiculosManager = $this->get('manager.vehiculos');

                if ($vehiculosManager->crearCheckList($vehiculo, $checkList, $daniosInternos)) {

                    $this->get('session')->getFlashBag()->add(
                            'success', 'Checklist Creado Correctamente'
                    );
                }
            }
        }

        $checklistPreEntrega = $em->getRepository('CuestionariosBundle:CuestionarioResultadoCabecera')->findOneByVehiculo($vehiculo);

        return $this->render(
                        'VehiculosBundle:Vehiculo:checkListPreEntrega.html.twig', array(
                    'categorias' => $categorias,
                    'cuestionario' => $cuestionario,
                    'vehiculo' => $vehiculo,
                    'formDanioInterno' => $formDaniosInternos->createView(),
                    'checklistPreEntrega' => $checklistPreEntrega,
                        )
        );
    }

    /*
     *
     */

    public function checkControlInternoAction(Request $request, $vehiculoId, $tipoTransaccion = "edit") {
        $em = $this->getDoctrine()->getManager();

        $vehiculo = $em->getRepository('VehiculosBundle:Vehiculo')->find($vehiculoId);

        $preguntas = $em->getRepository('VehiculosBundle:CheckControlInternoPregunta')->findBy(array('estado' => 'true'), array('orden' => 'asc'));
        $preguntasSelecionadas = $request->request;
        $controlInternoCabecera = $em->getRepository('VehiculosBundle:CheckControlInternoResultadoCabecera')->findOneByVehiculo($vehiculo);

        if (!$controlInternoCabecera) {
            $controlInternoCabecera = new \VehiculosBundle\Entity\CheckControlInternoResultadoCabecera();
            $controlInternoCabecera->setVehiculo($vehiculo);
            $controlInternoCabecera->setFirmado('false');
            $em->persist($controlInternoCabecera);
            $nuevo = true;
        } else {
            $nuevo = false;
        }

        if ($request->getMethod() == 'POST') {
            if ($tipoTransaccion == 'cierre') {
                $controlInternoCabecera->setFirmado('true');
                $em->persist($controlInternoCabecera);
                $tipoEstadoVehiculo = $em->getRepository('VehiculosBundle:TipoEstadoVehiculo')->findOneBySlug(
                        'entregado'
                );
                $estadoVehiculo = new EstadoVehiculo();
                $estadoVehiculo->setTipoEstadoVehiculo($tipoEstadoVehiculo);
                $estadoVehiculo->setVehiculo($vehiculo);
                $vehiculo->addEstadoVehiculo($estadoVehiculo);
//                $estadoActualVehiculo = $vehiculo->getEstadoVehiculo()->last()->getTipoEstadoVehiculo()->getSlug();
//                if ($estadoActualVehiculo == 'pendiente-por-entregar') {
//                    //si esta en estado 'pendiente-por-entregar' significa que el vehiculo se le esta haciendo 
//                    //un check para entregarlo al cliente final por lo tanto se pasa a estado 'entregado'
//                    //de lo contrario sigue en stock solo que se le hizo un check list para llevarlo a un reventa
//                    $tipoEstadoVehiculo = $em->getRepository('VehiculosBundle:TipoEstadoVehiculo')->findOneBySlug(
//                            'entregado'
//                    );
//                    $estadoVehiculo = new EstadoVehiculo();
//                    $estadoVehiculo->setTipoEstadoVehiculo($tipoEstadoVehiculo);
//                    $estadoVehiculo->setVehiculo($vehiculo);
//                    $vehiculo->addEstadoVehiculo($estadoVehiculo);
//                } else {
//                    //si no es pendiente-por-entregar puede ser un check de un vehiculo que se va a un reventa 
//                    //o de una entrega sin factura, en caso de entrega sin factura debe pasar a listado entregado, para saber esto
//                    //preguntamos que el cliente no sea un reventa
//                    if ($vehiculo->getCliente()) {
//                        if ($vehiculo->getCliente()->getReventa() != true) {
//                            //pasa  a entregado
//                            $tipoEstadoVehiculo = $em->getRepository('VehiculosBundle:TipoEstadoVehiculo')->findOneBySlug(
//                                    'entregado'
//                            );
//                            $estadoVehiculo = new EstadoVehiculo();
//                            $estadoVehiculo->setTipoEstadoVehiculo($tipoEstadoVehiculo);
//                            $estadoVehiculo->setVehiculo($vehiculo);
//                            $vehiculo->addEstadoVehiculo($estadoVehiculo);
//                        }
//                    }
//                }
            }
            if (!$nuevo) {
                $qb = $em->createQueryBuilder();
                $query = $qb->delete('VehiculosBundle:CheckControlInternoResultadoRespuesta', 'res')
                        ->where('res.checkControlInternoResultadoCabecera = :cabecera_id')
                        ->setParameter('cabecera_id', $controlInternoCabecera->getId())
                        ->getQuery();
                $query->execute();
            } else {
                $vehiculo->setCheckControlInternoResultadoCabecera($controlInternoCabecera);
                $em->persist($vehiculo);
            }

            $preguntasOriginales = null;
            foreach ($preguntas as $pregunta) {
                $preguntasOriginales[] = $pregunta->getId();
            }

            foreach ($preguntasSelecionadas as $preguntaId) {
                if (in_array($preguntaId, $preguntasOriginales)) {
                    $resultadoRespuesta = new \VehiculosBundle\Entity\CheckControlInternoResultadoRespuesta();
                    $resultadoRespuesta->setCheckControlInternoResultadoCabecera($controlInternoCabecera);
                    $pregunta = $em->getRepository('VehiculosBundle:CheckControlInternoPregunta')->find($preguntaId);
                    $resultadoRespuesta->setCheckControlInternoPregunta($pregunta);
                    $em->persist($resultadoRespuesta);
                }
            }
            $em->flush();
            if ($tipoTransaccion == 'cierre') {
                return $this->redirectToRoute('vehiculos_entregados_index');
            }
            $this->get('session')->getFlashBag()->add(
                    'success', 'Checklist Guardado Correctamente'
            );
            $cabecera = $controlInternoCabecera;
        } elseif (!$nuevo) {
            $preguntasSelecionadas = null;
            $respuestasGuardadas = $em->getRepository('VehiculosBundle:CheckControlInternoResultadoRespuesta')->findByCheckControlInternoResultadoCabecera($controlInternoCabecera);
            foreach ($respuestasGuardadas as $respuesta) {
                $preguntasSelecionadas[] = $respuesta->getCheckControlInternoPregunta()->getId();
            }
            $cabecera = $controlInternoCabecera;
        } else {
            $cabecera = false;
        }


        return $this->render(
                        'VehiculosBundle:Vehiculo:checkControlInterno.html.twig', array(
                    'preguntasOriginales' => $preguntas,
                    'preguntasSeleccionadas' => $preguntasSelecionadas,
                    'vehiculoId' => $vehiculoId,
                    'cabecera' => $cabecera,
                    'nuevo' => $nuevo,
                    'tipoTransaccion' => $tipoTransaccion,
                        )
        );
    }

    /**
     * Elimina una factura de un vehiculo tipo convencional o venta epsecial propia
     * y pone al vehiculo en estado stock.
     *
     */
    public function vehiculosEliminarFacturaAction(Request $request, $vehiculoId) {
        $em = $this->getDoctrine()->getManager();
        $vehiculo = $em->getRepository('VehiculosBundle:Vehiculo')->find($vehiculoId);
        if ($vehiculo->getFactura()) {

            $factura = $em->getRepository('VehiculosBundle:Factura')->find($vehiculo->getFactura()->getId());
            $em->remove($factura);
            $vehiculo->setFactura(null);
            $tipoEstadoVehiculo = $em->getRepository('VehiculosBundle:TipoEstadoVehiculo')->findOneBySlug('stock');
            $estadoVehiculo = new EstadoVehiculo();
            $estadoVehiculo->setTipoEstadoVehiculo($tipoEstadoVehiculo);
            $estadoVehiculo->setVehiculo($vehiculo);
            $vehiculo->addEstadoVehiculo($estadoVehiculo);

            $em->flush();


            $this->get('session')->getFlashBag()->add(
                    'success', 'La factura fue eliminada.'
            );
        } else {
            $this->get('session')->getFlashBag()->add(
                    'error', 'No se encuentra la factura.'
            );
        }
        return $this->redirect($this->generateUrl('vehiculos_show', array('id' => $vehiculoId)));
//        return $this->render(
//                        'VehiculosBundle:Vehiculo:show.html.twig', array(
//                    'entity' => $entity,
//                    'form' => $form->createView(),
//                        )
//        );
    }

    /**
     * Creates a form to delete a Factura entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteFacturaForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('vehiculos_eliminar_factura', array('vehiculoId' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Eliminar factura',
                            'attr' => array(
                                'class' => 'btn btn-danger',
                                'onclick' => 'return confirm("Al eliminar la factura se perderan todos los datos de la misma y no los podra recuperar, desea eliminar de todas formas?")')))
                        ->getForm()
        ;
    }

}
