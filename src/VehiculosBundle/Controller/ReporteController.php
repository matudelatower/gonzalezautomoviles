<?php

namespace VehiculosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use VehiculosBundle\Form\Filter\AutosVendidosPorVendedorFilterType;
use VehiculosBundle\Form\Filter\ReporteVehiculosAsignadosAReventaFilterType;
use VehiculosBundle\Form\Filter\ReporteVehiculosConDaniosFilterType;
use VehiculosBundle\Form\Filter\ReporteVehiculosDaniosGmFilterType;
use VehiculosBundle\Form\Filter\ReporteVehiculosDaniosInternosFilterType;
use VehiculosBundle\Form\Filter\VehiculosEnStockFilterType;
use VehiculosBundle\Form\Filter\VehiculosPlanAhorroFilterType;
use VehiculosBundle\Form\Filter\VehiculosPorDepositoFilterType;
use VehiculosBundle\Form\Filter\VehiculosCuponGarantiaFilterType;
use VehiculosBundle\Form\Filter\ReporteAgendaEntregasFilterType;
use VehiculosBundle\Form\Filter\ReportePatentamientosFilterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UsuariosBundle\Controller\TokenAuthenticatedController;

class ReporteController extends Controller implements TokenAuthenticatedController {

    public function indexReporteAutosVendidosPorVendedorAction(Request $request) {

        $form = $this->createForm(new AutosVendidosPorVendedorFilterType());

        $entities = array();

        $reportesManager = $this->get('manager.reportes');

        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            $formData = $form->getData();

            $vendedor = $formData['vendedor'];
            if ($formData['rango']) {
                $aFecha = explode(' - ', $formData['rango']);

                $fechaDesde = \DateTime::createFromFormat('d/m/Y', $aFecha[0]);
                $fechaHasta = \DateTime::createFromFormat('d/m/Y', $aFecha[1]);
                $entities = $reportesManager->getAutosVendidosPorVendedor($vendedor, $fechaDesde, $fechaHasta);
            } else {
                $entities = $reportesManager->getAutosVendidosPorVendedor($vendedor);
            }
        }
        $cantidadRegistros = count($entities);

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
                $entities, $request->query->get('page', 1)/* page number */, 30/* limit per page */
        );

        return $this->render('VehiculosBundle:Reporte:reporteAutosVendidosPorVendedor.html.twig', array(
                    'entities' => $entities,
                    'form' => $form->createView(),
                    'cantidadRegistros' => $cantidadRegistros,
        ));
    }

    public function pdfReporteAutosVendidosPorVendedorAction(Request $request) {
        $form = $this->createForm(new AutosVendidosPorVendedorFilterType());

        $entities = array();

        $reportesManager = $this->get('manager.reportes');

        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            $formData = $form->getData();

            $vendedor = $formData['vendedor'];
            if ($formData['rango']) {
                $aFecha = explode(' - ', $formData['rango']);

                $fechaDesde = \DateTime::createFromFormat('d/m/Y', $aFecha[0]);
                $fechaHasta = \DateTime::createFromFormat('d/m/Y', $aFecha[1]);

                $entities = $reportesManager->getAutosVendidosPorVendedor($vendedor, $fechaDesde, $fechaHasta);
            } else {
                $fechaDesde = null;
                $fechaHasta = null;
                $entities = $reportesManager->getAutosVendidosPorVendedor($vendedor);
            }
        }

        $title = 'Reporte de Autos Vendidos Por Vendedor';

        $html = $this->renderView(
                'VehiculosBundle:Reporte:reporteAutosVendidosPorVendedor.pdf.twig', array(
            'entities' => $entities,
            'title' => $title,
            'vendedor' => $vendedor,
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta
                )
        );

        return new Response(
                $reportesManager->imprimir($html)
                , 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $title . '.pdf"'
                )
        );
    }

    public function excelReporteAutosVendidosPorVendedorAction(Request $request) {

        $form = $this->createForm(new AutosVendidosPorVendedorFilterType());

        $entities = array();

        $reportesManager = $this->get('manager.reportes');

        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            $formData = $form->getData();

            $vendedor = $formData['vendedor'];
            if ($formData['rango']) {
                $aFecha = explode(' - ', $formData['rango']);

                $fechaDesde = \DateTime::createFromFormat('d/m/Y', $aFecha[0]);
                $fechaHasta = \DateTime::createFromFormat('d/m/Y', $aFecha[1]);
                $entities = $reportesManager->getAutosVendidosPorVendedor($vendedor, $fechaDesde, $fechaHasta);
            } else {
                $entities = $reportesManager->getAutosVendidosPorVendedor($vendedor);
            }
        }
        $filename = "reporte_autos_vendidos_por_vendedor.xls";



        $exportExcel = $this->get('excel.tool');
        $exportExcel->setTitle('Autos Vendidos por Vendedor');
        $exportExcel->setDescripcion('Listado de Autos Vendidos por Vendedor');



        $response = $exportExcel->buildSheetgetReporteAutosVendidosPorVendedor($entities);

        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=' . $filename . '');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');

        return $response;
    }

    public function indexReporteVehiculosEnStockAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new VehiculosEnStockFilterType($em));

        $entities = array();


        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();

                $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosEnStock($data);
            }
        }
        $cantidadRegistros = count($entities);
        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
                $entities, $request->query->get('page', 1)/* page number */, 30/* limit per page */
        );

        return $this->render('VehiculosBundle:Reporte:reporteVehiculosEnStock.html.twig', array(
                    'entities' => $entities,
                    'form' => $form->createView(),
                    'cantidadRegistros' => $cantidadRegistros,
        ));
    }

    public function excelReporteVehiculosEnStockAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new VehiculosEnStockFilterType($em));

        $entities = array();

//        $reportesManager = $this->get('manager.reportes');

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosEnStock($data);
            }
        }
        $filename = "reporte_vehiculos_en_stock.xls";



        $exportExcel = $this->get('excel.tool');
        $exportExcel->setTitle('Vehiculos En Stock');
        $exportExcel->setDescripcion('Listado de Vehiculos En Stock');


//        $managerEncuestas = $this->get('manager.reportes');
//        $entities = $managerEncuestas->getAutosVendidosPorVendedor($vendedor, $fechaDesde, $fechaHasta);


        $response = $exportExcel->buildSheetgetReporteVehiculosEnStock($entities);

        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=' . $filename . '');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');

        return $response;
    }

    public function pdfReporteVehiculosEnStockAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new VehiculosEnStockFilterType($em));

        $entities = array();

        $reportesManager = $this->get('manager.reportes');

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosEnStock($data);
            }
        }

        $title = 'Reporte de Vehiculos en Stock';

        $html = $this->renderView(
                'VehiculosBundle:Reporte:reporteVehiculosEnStock.pdf.twig', array(
            'entities' => $entities,
            'title' => $title,
                )
        );

        return new Response(
                $reportesManager->imprimir($html, "H"), 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $title . '.pdf"'
                )
        );
    }

    /*
     * devuelve las entregas programadas en un rango de fechas.
     */

    public function indexReporteAgendaEntregasAction(Request $request) {

        $form = $this->createForm(new ReporteAgendaEntregasFilterType());

        $entities = array();

        $reportesManager = $this->get('manager.reportes');

        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            $formData = $form->getData();

//            $vendedor = $formData['vendedor'];

            $aFecha = explode(' - ', $formData['rango']);

            $fechaDesde = \DateTime::createFromFormat('d/m/Y', $aFecha[0]);
            $fechaHasta = \DateTime::createFromFormat('d/m/Y', $aFecha[1]);

            $entities = $reportesManager->getAgendaEntregas($fechaDesde, $fechaHasta);
        }
        $cantidadRegistros = count($entities);
        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
                $entities, $request->query->get('page', 1)/* page number */, 30/* limit per page */
        );

        return $this->render('VehiculosBundle:Reporte:reporteAgendaEntregas.html.twig', array(
                    'entities' => $entities,
                    'form' => $form->createView(),
                    'cantidadRegistros' => $cantidadRegistros,
        ));
    }

    /*
     * 
     */

    public function pdfReporteAgendaEntregasAction(Request $request) {

        $form = $this->createForm(new ReporteAgendaEntregasFilterType());

        $entities = array();

        $reportesManager = $this->get('manager.reportes');

        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            $formData = $form->getData();

            $aFecha = explode(' - ', $formData['rango']);

            $fechaDesde = \DateTime::createFromFormat('d/m/Y', $aFecha[0]);
            $fechaHasta = \DateTime::createFromFormat('d/m/Y', $aFecha[1]);

            $entities = $reportesManager->getAgendaEntregas($fechaDesde, $fechaHasta);
        }

        $title = 'Reporte de Entregas Programadas';

        $html = $this->renderView(
                'VehiculosBundle:Reporte:reporteAgendaEntregas.pdf.twig', array(
            'entities' => $entities,
            'title' => $title,
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta
                )
        );

        return new Response(
                $reportesManager->imprimir($html, 'H')
                , 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $title . '.pdf"'
                )
        );
    }

    public function excelReporteAgendaEntregasAction(Request $request) {

        $form = $this->createForm(new ReporteAgendaEntregasFilterType());

        $entities = array();

        $reportesManager = $this->get('manager.reportes');

        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            $formData = $form->getData();

            $aFecha = explode(' - ', $formData['rango']);

            $fechaDesde = \DateTime::createFromFormat('d/m/Y', $aFecha[0]);
            $fechaHasta = \DateTime::createFromFormat('d/m/Y', $aFecha[1]);

            $entities = $reportesManager->getAgendaEntregas($fechaDesde, $fechaHasta);
        }

        $filename = "reporte_entregas_programadas.xls";



        $exportExcel = $this->get('excel.tool');
        $exportExcel->setTitle('Entregas Programadas');
        $exportExcel->setDescripcion('Listado de Entregas Programadas');


        $response = $exportExcel->buildSheetgetReporteAgendaEntregas($entities);

        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=' . $filename . '');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');

        return $response;
    }

    /*
     * crea un pdf con los datos del show de un vehiculo
     */

    public function resumenVehiculoPdfAction($vehiculoId) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:Vehiculo')->find($vehiculoId);

        $title = 'Resumen de Vehículo';
        $reportesManager = $this->get('manager.reportes');
        $html = $this->render(
                'VehiculosBundle:Reporte:resumenVehiculo.pdf.twig', array(
            'entity' => $entity,
            'title' => $title,
                )
        );

        return new Response(
                $reportesManager->imprimir($html), 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $title . '.pdf"'
                )
        );
    }

    public function indexReporteVehiculosCuponGarantiaAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new VehiculosCuponGarantiaFilterType());

        $entities = array();

//        $reportesManager = $this->get('manager.reportes');

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosCuponGarantia($data);
            }
        }
        $cantidadRegistros = count($entities);
        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
                $entities, $request->query->get('page', 1)/* page number */, 30/* limit per page */
        );

        return $this->render('VehiculosBundle:Reporte:reporteVehiculosCuponGarantia.html.twig', array(
                    'entities' => $entities,
                    'form' => $form->createView(),
                    'cantidadRegistros' => $cantidadRegistros,
        ));
    }

    public function pdfReporteVehiculosCuponGarantiaAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new VehiculosCuponGarantiaFilterType());

        $entities = array();

        $reportesManager = $this->get('manager.reportes');

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosCuponGarantia($data);
            }
        }
        if ($data['conCupon'] == 'SI') {
            $title = 'Reporte de Vehículos que tienen Cupon de Garantia';
        } else {
            $title = 'Reporte de Vehículos que NO tienen Cupon de Garantia';
        }

        $html = $this->renderView(
                'VehiculosBundle:Reporte:reporteVehiculosCuponGarantia.pdf.twig', array(
            'entities' => $entities,
            'title' => $title,
            'tipo' => $data['conCupon'],
                )
        );

        return new Response(
                $reportesManager->imprimir($html), 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $title . '.pdf"'
                )
        );
    }

    public function excelReporteVehiculosCuponGarantiaAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new VehiculosCuponGarantiaFilterType());

        $entities = array();

//        $reportesManager = $this->get('manager.reportes');

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosCuponGarantia($data);
            }
        }

        $exportExcel = $this->get('excel.tool');

        if ($data['conCupon'] == 'SI') {
            $filename = "reporte_vehiculos_con_cupon_garantia.xls";
            $exportExcel->setTitle('Vehiculos Con Cupon de Garantia');
            $exportExcel->setDescripcion('Vehiculos Con Cupon de Garantia');
            $response = $exportExcel->buildSheetgetReporteVehiculosConCuponGarantia($entities);
        } else {
            $filename = "reporte_vehiculos_sin_cupon_garantia.xls";
            $exportExcel->setTitle('Vehiculos Sin Cupon de Garantia');
            $exportExcel->setDescripcion('Vehiculos Sin Cupon de Garantia');
            $response = $exportExcel->buildSheetgetReporteVehiculosSinCuponGarantia($entities);
        }




//        $managerEncuestas = $this->get('manager.reportes');
//        $entities = $managerEncuestas->getAutosVendidosPorVendedor($vendedor, $fechaDesde, $fechaHasta);


        $response = $exportExcel->buildSheetgetReporteVehiculosConCuponGarantia($entities);

        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=' . $filename . '');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');

        return $response;
    }

    public function indexReporteVehiculosRecibidosConDaniosAction(Request $request) {
        $form = $this->createForm(new ReporteVehiculosConDaniosFilterType());

        $entities = array();

        $reportesManager = $this->get('manager.reportes');

        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            $formData = $form->getData();

            $aFecha = explode(' - ', $formData['rango']);

            $fechaDesde = \DateTime::createFromFormat('d/m/Y', $aFecha[0]);
            $fechaHasta = \DateTime::createFromFormat('d/m/Y', $aFecha[1]);

            $entities = $reportesManager->reporteVehiculosRecibidosConDanios($fechaDesde, $fechaHasta);
        }

        return $this->render('VehiculosBundle:Reporte:reporteVehiculosRecibidosConDanios.html.twig', array(
                    'entities' => $entities,
                    'form' => $form->createView()
        ));
    }

    public function pdfReporteVehiculosRecibidosConDaniosAction(Request $request) {
        $form = $this->createForm(new ReporteVehiculosConDaniosFilterType());

        $entities = array();

        $reportesManager = $this->get('manager.reportes');

        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            $formData = $form->getData();

            $aFecha = explode(' - ', $formData['rango']);

            $fechaDesde = \DateTime::createFromFormat('d/m/Y', $aFecha[0]);
            $fechaHasta = \DateTime::createFromFormat('d/m/Y', $aFecha[1]);

            $entities = $reportesManager->reporteVehiculosRecibidosConDanios($fechaDesde, $fechaHasta);
        }

        $title = 'Reporte de Vehículos Recibidos Con Daños';

        $html = $this->renderView(
                'VehiculosBundle:Reporte:reporteVehiculosRecibidosConDanios.pdf.twig', array(
            'entities' => $entities,
            'title' => $title,
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta
                )
        );

        return new Response(
                $reportesManager->imprimir($html)
                , 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $title . '.pdf"'
                )
        );
    }

    public function excelReporteVehiculosRecibidosConDaniosAction(Request $request) {
        $form = $this->createForm(new ReporteVehiculosConDaniosFilterType());

        $entities = array();

        $reportesManager = $this->get('manager.reportes');

        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            $formData = $form->getData();

            $aFecha = explode(' - ', $formData['rango']);

            $fechaDesde = \DateTime::createFromFormat('d/m/Y', $aFecha[0]);
            $fechaHasta = \DateTime::createFromFormat('d/m/Y', $aFecha[1]);

            $entities = $reportesManager->reporteVehiculosRecibidosConDanios($fechaDesde, $fechaHasta);
        }

        $filename = "reporte_vehiculos_recibidos_con_danios.xls";



        $exportExcel = $this->get('excel.tool');
        $exportExcel->setTitle('Vehiculos Recibidos Con Daños');
        $exportExcel->setDescripcion('Listado de Vehiculos Recibidos Con Daños');

        $response = $exportExcel->buildSheetReporteVehiculosRecibidosConDanios($entities);

        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=' . $filename . '');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');

        return $response;
    }

    public function pdfCheckControlInternoAction($vehiculoId) {
        $em = $this->getDoctrine()->getManager();

        $vehiculo = $em->getRepository('VehiculosBundle:Vehiculo')->find($vehiculoId);
        $controlInternoCabecera = $em->getRepository('VehiculosBundle:CheckControlInternoResultadoCabecera')->findOneByVehiculo($vehiculo);

        $preguntas = $em->getRepository('VehiculosBundle:CheckControlInternoPregunta')->findBy(array('estado' => 'true'), array('orden' => 'asc'));


        $preguntasSeleccionadas = null;
        $respuestasGuardadas = $em->getRepository('VehiculosBundle:CheckControlInternoResultadoRespuesta')->findByCheckControlInternoResultadoCabecera($controlInternoCabecera);
        foreach ($respuestasGuardadas as $respuesta) {
            $preguntasSeleccionadas[] = $respuesta->getCheckControlInternoPregunta()->getId();
        }

        $title = 'Inspeccion del vehículo Control Interno';

        $html = $this->renderView(
                'VehiculosBundle:Reporte:checkControlInterno.pdf.twig', array(
            'preguntasSeleccionadas' => $preguntasSeleccionadas,
            'vehiculo' => $vehiculo,
            'title' => '',
            'preguntasOriginales' => $preguntas,
            'controlInternoCabecera' => $controlInternoCabecera,
                )
        );
        $reportesManager = $this->get('manager.reportes');
        return new Response(
                $reportesManager->imprimirCheckControlInterno($html)
                , 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $title . '.pdf"'
                )
        );
    }

    /*
     * 
     */

    public function indexReporteVehiculosPorDepositoAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new VehiculosPorDepositoFilterType());

        $entities = array();

//        $reportesManager = $this->get('manager.reportes');

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosPorDeposito($data);
            }
        }
        $cantidadRegistros = count($entities);
        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
                $entities, $request->query->get('page', 1)/* page number */, 30/* limit per page */
        );

        return $this->render('VehiculosBundle:Reporte:reporteVehiculosPorDeposito.html.twig', array(
                    'entities' => $entities,
                    'form' => $form->createView(),
                    'cantidadRegistros' => $cantidadRegistros,
        ));
    }

    public function excelReporteVehiculosPorDepositoAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new VehiculosPorDepositoFilterType());

        $entities = array();

//        $reportesManager = $this->get('manager.reportes');

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosPorDeposito($data);
            }
        }
        $filename = "reporte_vehiculos_por_deposito.xls";



        $exportExcel = $this->get('excel.tool');
        $exportExcel->setTitle('Vehiculos Por Deposito');
        $exportExcel->setDescripcion('Listado de Vehiculos Por Deposito');


//        $managerEncuestas = $this->get('manager.reportes');
//        $entities = $managerEncuestas->getAutosVendidosPorVendedor($vendedor, $fechaDesde, $fechaHasta);


        $response = $exportExcel->buildSheetgetReporteVehiculosPorDeposito($entities);

        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=' . $filename . '');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');

        return $response;
    }

    public function pdfReporteVehiculosPorDepositoAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new VehiculosPorDepositoFilterType());

        $entities = array();

        $reportesManager = $this->get('manager.reportes');

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosPorDeposito($data);
            }
        }

        $title = 'Reporte de Vehículos por Deposito';

        $html = $this->renderView(
                'VehiculosBundle:Reporte:reporteVehiculosPorDeposito.pdf.twig', array(
            'entities' => $entities,
            'title' => $title,
                )
        );

        return new Response(
                $reportesManager->imprimir($html), 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $title . '.pdf"'
                )
        );
    }

    public function indexReporteVehiculosConDaniosInternosAction(Request $request) {
        $form = $this->createForm(new ReporteVehiculosConDaniosFilterType());

        $entities = array();

        $reportesManager = $this->get('manager.reportes');

        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            $formData = $form->getData();

            $aFecha = explode(' - ', $formData['rango']);

            $fechaDesde = \DateTime::createFromFormat('d/m/Y', $aFecha[0]);
            $fechaHasta = \DateTime::createFromFormat('d/m/Y', $aFecha[1]);

            $entities = $reportesManager->reporteVehiculosConDanios($fechaDesde, $fechaHasta);
        }

        return $this->render('VehiculosBundle:Reporte:reporteVehiculosConDaniosInternos.html.twig', array(
                    'entities' => $entities,
                    'form' => $form->createView()
        ));
    }

    public function pdfReporteVehiculosConDaniosInternosAction(Request $request) {
        $form = $this->createForm(new ReporteVehiculosConDaniosFilterType());

        $entities = array();

        $reportesManager = $this->get('manager.reportes');

        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            $formData = $form->getData();

            $aFecha = explode(' - ', $formData['rango']);

            $fechaDesde = \DateTime::createFromFormat('d/m/Y', $aFecha[0]);
            $fechaHasta = \DateTime::createFromFormat('d/m/Y', $aFecha[1]);

            $entities = $reportesManager->reporteVehiculosConDanios($fechaDesde, $fechaHasta);
        }

        $title = 'Reporte de Vehículos  Con Daños Internos';

        $html = $this->renderView(
                'VehiculosBundle:Reporte:reporteVehiculosRecibidosConDanios.pdf.twig', array(
            'entities' => $entities,
            'title' => $title,
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta
                )
        );

        return new Response(
                $reportesManager->imprimir($html)
                , 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $title . '.pdf"'
                )
        );
    }

    public function excelReporteVehiculosConDaniosInternosAction(Request $request) {
        $form = $this->createForm(new ReporteVehiculosConDaniosFilterType());

        $entities = array();

        $reportesManager = $this->get('manager.reportes');

        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);


            $formData = $form->getData();

            $aFecha = explode(' - ', $formData['rango']);

            $fechaDesde = \DateTime::createFromFormat('d/m/Y', $aFecha[0]);
            $fechaHasta = \DateTime::createFromFormat('d/m/Y', $aFecha[1]);

            $entities = $reportesManager->reporteVehiculosConDanios($fechaDesde, $fechaHasta);
        }

        $filename = "reporte_vehiculos_recibidos_con_danios.xls";



        $exportExcel = $this->get('excel.tool');
        $exportExcel->setTitle('Vehiculos Con Daños Internos');
        $exportExcel->setDescripcion('Listado de Vehiculos Con Daños Internos');

        $response = $exportExcel->buildSheetReporteVehiculosRecibidosConDanios($entities);

        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=' . $filename . '');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');

        return $response;
    }

    public function indexReporteVehiculosAsignadosAReventaAction(Request $request) {
        $form = $this->createForm(new ReporteVehiculosAsignadosAReventaFilterType());

        $entities = array();

        $reportesManager = $this->get('manager.reportes');

        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            $formData = $form->getData();
            if ($formData['reventa']) {
                if ($formData['dias']) {
                    $dias = explode(',', $formData['dias']);

                    $formData['diaInicio'] = abs($dias[0]);
                    $formData['diaFin'] = abs($dias[1]);
                } else {
                    $formData['diaInicio'] = false;
                    $formData['diaFin'] = false;
                }
                $entities = $reportesManager->getVehiculosAsignadosAReventa($formData);
            }
        }
        $cantidadRegistros = count($entities);
        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
                $entities, $request->query->get('page', 1)/* page number */, 30/* limit per page */
        );

        return $this->render('VehiculosBundle:Reporte:reporteVehiculosAsignadosAReventa.html.twig', array(
                    'entities' => $entities,
                    'form' => $form->createView(),
                    'cantidadRegistros' => $cantidadRegistros,
        ));
    }

    public function pdfReporteVehiculosAsignadosAReventaAction(Request $request) {
        $form = $this->createForm(new ReporteVehiculosAsignadosAReventaFilterType());

        $entities = array();

        $reportesManager = $this->get('manager.reportes');

        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            $formData = $form->getData();
            if ($formData['reventa']) {

                if ($formData['dias']) {
                    $dias = explode(',', $formData['dias']);

                    $formData['diaInicio'] = abs($dias[0]);
                    $formData['diaFin'] = abs($dias[1]);
                } else {
                    $formData['diaInicio'] = false;
                    $formData['diaFin'] = false;
                }

                $entities = $reportesManager->getVehiculosAsignadosAReventa($formData);
            }
        }

        $title = 'Reporte de Vehículos Asignados a Reventa';

        $html = $this->renderView(
                'VehiculosBundle:Reporte:reporteVehiculosAsignadosAReventa.pdf.twig', array(
            'entities' => $entities,
            'title' => $title,
            'reventa' => $formData['reventa']
                )
        );

        return new Response(
                $reportesManager->imprimir($html)
                , 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $title . '.pdf"'
                )
        );
    }

    public function excelReporteVehiculosAsignadosAReventaAction(Request $request) {
        $form = $this->createForm(new ReporteVehiculosAsignadosAReventaFilterType());

        $entities = array();

        $reportesManager = $this->get('manager.reportes');

        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            $formData = $form->getData();
            if ($formData['reventa']) {
                if ($formData['dias']) {
                    $dias = explode(',', $formData['dias']);

                    $formData['diaInicio'] = abs($dias[0]);
                    $formData['diaFin'] = abs($dias[1]);
                } else {
                    $formData['diaInicio'] = false;
                    $formData['diaFin'] = false;
                }

                $entities = $reportesManager->getVehiculosAsignadosAReventa($formData);
            }
        }

        $filename = "reporte_vehiculos_asignados_a_reventa.xls";


        $exportExcel = $this->get('excel.tool');
        $exportExcel->setTitle('Vehiculos Asignados a Reventa');
        $exportExcel->setDescripcion('Listado de Vehiculos Asignados a Reventa');

        $response = $exportExcel->buildSheetReporteVehiculosAsignadosAReventa($entities);

        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=' . $filename . '');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');

        return $response;
    }

    /*
     *
     */

    public function indexReporteVehiculosPatentamientosAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new ReportePatentamientosFilterType());

        $entities = array();

        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            $data = $form->getData();

            $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosPatentamientos($data);
        }
        $cantidadRegistros = count($entities);
        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
                $entities, $request->query->get('page', 1)/* page number */, 30/* limit per page */
        );

        return $this->render('VehiculosBundle:Reporte:reporteVehiculosPatentamientos.html.twig', array(
                    'entities' => $entities,
                    'form' => $form->createView(),
                    'cantidadRegistros' => $cantidadRegistros,
        ));
    }

    public function pdfReporteVehiculosPatentamientosAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new ReportePatentamientosFilterType());

        $entities = array();

        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            $data = $form->getData();
            if ($data['rango']) {
                $aFecha = explode(' - ', $data['rango']);

                $fechaDesde = \DateTime::createFromFormat('d/m/Y', $aFecha[0]);
                $fechaHasta = \DateTime::createFromFormat('d/m/Y', $aFecha[1]);
                $fecha = true;
            } else {
                $fecha = false;
                $fechaDesde = null;
                $fechaHasta = null;
            }
            $estado = $data['estado'];

            $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosPatentamientos($data);
        }

        $title = 'Reporte de Patentamientos';

        $html = $this->renderView(
                'VehiculosBundle:Reporte:reporteVehiculosPatentamientos.pdf.twig', array(
            'entities' => $entities,
            'title' => $title,
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
            'fecha' => $fecha,
            'estado' => $estado
                )
        );
        $reportesManager = $this->get('manager.reportes');
        return new Response(
                $reportesManager->imprimir($html, 'H')
                , 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $title . '.pdf"'
                )
        );
    }

    public function excelReporteVehiculosPatentamientosAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new ReportePatentamientosFilterType());

        $entities = array();

        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            $data = $form->getData();

            $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosPatentamientos($data);
        }

        $filename = "reporte_vehiculos_patentamientos.xls";



        $exportExcel = $this->get('excel.tool');
        $exportExcel->setTitle('Vehiculos Patentamientos');
        $exportExcel->setDescripcion('Listado de Vehiculos Patentamientos');

        $response = $exportExcel->buildSheetReporteVehiculosPatentamientos($entities);

        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=' . $filename . '');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');

        return $response;
    }

    /*
     * reporte de vehiculos que tengan daños de gm sin solucionar
     */

    public function indexReporteVehiculosDaniosGmAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
//        $form = $this->createForm(new ReporteVehiculosConDaniosFilterType());
        $form = $this->createForm(new ReporteVehiculosDaniosGmFilterType($em));


        $entities = array();


        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();

                $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosDaniosGm($data);
            }
        }


        $cantidadRegistros = count($entities);
        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
                $entities, $request->query->get('page', 1)/* page number */, 30/* limit per page */
        );

        return $this->render('VehiculosBundle:Reporte:reporteVehiculosDaniosGm.html.twig', array(
                    'entities' => $entities,
                    'form' => $form->createView(),
                    'cantidadRegistros' => $cantidadRegistros,
        ));
    }

    public function pdfReporteVehiculosDaniosGmAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new ReporteVehiculosDaniosGmFilterType($em));


        $entities = array();


        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                if ($data['rango']) {
                    $aFecha = explode(' - ', $data['rango']);
                    $fechaDesde = \DateTime::createFromFormat('d/m/Y', $aFecha[0]);
                    $fechaHasta = \DateTime::createFromFormat('d/m/Y', $aFecha[1]);
                    $fecha = true;
                } else {
                    $fecha = false;
                    $fechaDesde = null;
                    $fechaHasta = null;
                }
                if ($data['tipoEstadoDanioGm']) {
                    $estado = $data['tipoEstadoDanioGm']->getSlug();
                } else {
                    $estado = false;
                }
                $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosDaniosGm($data);
            }
        }

        $title = 'Reporte vehiculos con daños de GM';

        $html = $this->renderView(
                'VehiculosBundle:Reporte:reporteVehiculosDaniosGm.pdf.twig', array(
            'entities' => $entities,
            'title' => $title,
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
            'fecha' => $fecha,
            'estado' => $estado,
                )
        );
        $reportesManager = $this->get('manager.reportes');
        return new Response(
                $reportesManager->imprimir($html, 'H')
                , 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $title . '.pdf"'
                )
        );
    }
    
     public function excelReporteVehiculosDaniosGmAction(Request $request) {
       $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new ReporteVehiculosDaniosGmFilterType($em));


        $entities = array();


        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();               
                $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosDaniosGm($data);
            }
        }


        $filename = "reporte_vehiculos_con_danios_gm.xls";



        $exportExcel = $this->get('excel.tool');
        $exportExcel->setTitle('Vehiculos Con Danios De GM');
        $exportExcel->setDescripcion('Listado de Vehiculos Con Danios De GM');

        $response = $exportExcel->buildSheetReporteVehiculosDaniosGm($entities);

        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=' . $filename . '');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');

        return $response;
    }
    
    /*
     * reporte de vehiculos que tengan daños de gm sin solucionar
     */

    public function indexReporteVehiculosDaniosInternosAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
//        $form = $this->createForm(new ReporteVehiculosConDaniosFilterType());
        $form = $this->createForm(new ReporteVehiculosDaniosInternosFilterType());


        $entities = array();


        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();

                $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosDaniosInternos($data);
            }
        }


        $cantidadRegistros = count($entities);
        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
                $entities, $request->query->get('page', 1)/* page number */, 30/* limit per page */
        );

        return $this->render('VehiculosBundle:Reporte:reporteVehiculosDaniosInternos.html.twig', array(
                    'entities' => $entities,
                    'form' => $form->createView(),
                    'cantidadRegistros' => $cantidadRegistros,
        ));
    }

    public function pdfReporteVehiculosDaniosInternosAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new ReporteVehiculosDaniosInternosFilterType());


        $entities = array();


        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                if ($data['rango']) {
                    $aFecha = explode(' - ', $data['rango']);
                    $fechaDesde = \DateTime::createFromFormat('d/m/Y', $aFecha[0]);
                    $fechaHasta = \DateTime::createFromFormat('d/m/Y', $aFecha[1]);
                    $fecha = true;
                } else {
                    $fecha = false;
                    $fechaDesde = null;
                    $fechaHasta = null;
                }
                $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosDaniosInternos($data);
            }
        }

        $title = 'Reporte vehiculos con daños internos';

        $html = $this->renderView(
                'VehiculosBundle:Reporte:reporteVehiculosDaniosInternos.pdf.twig', array(
            'entities' => $entities,
            'title' => $title,
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
            'fecha' => $fecha,
                )
        );
        $reportesManager = $this->get('manager.reportes');
        return new Response(
                $reportesManager->imprimir($html, 'H')
                , 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $title . '.pdf"'
                )
        );
    }
    
     public function excelReporteVehiculosDaniosInternosAction(Request $request) {
       $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new ReporteVehiculosDaniosInternosFilterType());


        $entities = array();


        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();               
                $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosDaniosInternos($data);
            }
        }


        $filename = "reporte_vehiculos_con_danios_internos.xls";



        $exportExcel = $this->get('excel.tool');
        $exportExcel->setTitle('Vehiculos Con Danios Internos');
        $exportExcel->setDescripcion('Listado de Vehiculos Con Danios Internos');

        $response = $exportExcel->buildSheetReporteVehiculosDaniosInternos($entities);

        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=' . $filename . '');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');

        return $response;
    }
    
    /*
     * reporte vehiculo plan de ahorro (tránsito, recibidos y pendientes por entregar)
     */
    
     public function indexReporteVehiculosPlanAhorroAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new VehiculosPlanAhorroFilterType($em));

        $entities = array();


        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();

                $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosPlanAhorro($data);
            }
        }
        $cantidadRegistros = count($entities);
        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
                $entities, $request->query->get('page', 1)/* page number */, 30/* limit per page */
        );

        return $this->render('VehiculosBundle:Reporte:reporteVehiculosPlanAhorro.html.twig', array(
                    'entities' => $entities,
                    'form' => $form->createView(),
                    'cantidadRegistros' => $cantidadRegistros,
        ));
    }

    public function excelReporteVehiculosPlanAhorroAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new VehiculosPlanAhorroFilterType($em));

        $entities = array();

//        $reportesManager = $this->get('manager.reportes');

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosPlanAhorro($data);
            }
        }
        $filename = "reporte_vehiculos_plan_ahorro.xls";



        $exportExcel = $this->get('excel.tool');
        $exportExcel->setTitle('Vehiculos Plan de Ahorro');
        $exportExcel->setDescripcion('Listado de Vehiculos Plan de Ahorro');


//        $managerEncuestas = $this->get('manager.reportes');
//        $entities = $managerEncuestas->getAutosVendidosPorVendedor($vendedor, $fechaDesde, $fechaHasta);


        $response = $exportExcel->buildSheetgetReporteVehiculosPlanAhorro($entities);

        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=' . $filename . '');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');

        return $response;
    }

    public function pdfReporteVehiculosPlanAhorroAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new VehiculosPlanAhorroFilterType($em));

        $entities = array();

        $reportesManager = $this->get('manager.reportes');

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosPlanAhorro($data);
            }
        }

        $title = 'Reporte de Vehiculos de Plan de ahorro';

        $html = $this->renderView(
                'VehiculosBundle:Reporte:reporteVehiculosPlanAhorro.pdf.twig', array(
            'entities' => $entities,
            'title' => $title,
                )
        );

        return new Response(
                $reportesManager->imprimir($html, "H"), 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $title . '.pdf"'
                )
        );
    }


}
