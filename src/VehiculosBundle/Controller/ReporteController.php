<?php

namespace VehiculosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use VehiculosBundle\Form\Filter\AutosVendidosPorVendedorFilterType;
use VehiculosBundle\Form\Filter\VehiculosEnStockFilterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReporteController extends Controller {

    public function indexReporteAutosVendidosPorVendedorAction(Request $request) {

        $form = $this->createForm(new AutosVendidosPorVendedorFilterType());

        $entities = array();

        $reportesManager = $this->get('manager.reportes');

        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            $formData = $form->getData();

            $vendedor = $formData['vendedor'];

            $aFecha = explode(' - ', $formData['rango']);

            $fechaDesde = \DateTime::createFromFormat('d/m/Y', $aFecha[0]);
            $fechaHasta = \DateTime::createFromFormat('d/m/Y', $aFecha[1]);

            $entities = $reportesManager->getAutosVendidosPorVendedor($vendedor, $fechaDesde, $fechaHasta);
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
                $entities, $request->query->get('page', 1)/* page number */, 30/* limit per page */
        );

        return $this->render('VehiculosBundle:Reporte:reporteAutosVendidosPorVendedor.html.twig', array(
                    'entities' => $entities,
                    'form' => $form->createView()
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

            $aFecha = explode(' - ', $formData['rango']);

            $fechaDesde = \DateTime::createFromFormat('d/m/Y', $aFecha[0]);
            $fechaHasta = \DateTime::createFromFormat('d/m/Y', $aFecha[1]);

            $entities = $reportesManager->getAutosVendidosPorVendedor($vendedor, $fechaDesde, $fechaHasta);
        }

        $html = $this->renderView(
                'VehiculosBundle:Reporte:reporteAutosVendidosPorVendedor.pdf.twig', array(
            'entities' => $entities
                )
        );

        return new Response(
                $this->get('knp_snappy.pdf')->getOutputFromHtml($html, array(
                    'margin-left' => '1cm',
                    'margin-right' => '1cm',
                    'margin-top' => '1cm',
                    'margin-bottom' => '1cm',
                )), 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="Reporte_autos_por_vendedor.pdf"'
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

            $aFecha = explode(' - ', $formData['rango']);

            $fechaDesde = \DateTime::createFromFormat('d/m/Y', $aFecha[0]);
            $fechaHasta = \DateTime::createFromFormat('d/m/Y', $aFecha[1]);

            $entities = $reportesManager->getAutosVendidosPorVendedor($vendedor, $fechaDesde, $fechaHasta);
        }
        $filename = "reporte_autos_vendidos_por_vendedor.xls";



        $exportExcel = $this->get('excel.tool');
        $exportExcel->setTitle('Autos Vendidos por Vendedor');
        $exportExcel->setDescripcion('Listado de Autos Vendidos por Vendedor');


        $managerEncuestas = $this->get('manager.reportes');

        $entities = $managerEncuestas->getAutosVendidosPorVendedor($vendedor, $fechaDesde, $fechaHasta);


        $response = $exportExcel->buildSheetgetReporteAutosVendidosPorVendedor($entities);

        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=' . $filename . '');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');

        return $response;
    }

    public function indexReporteVehiculosEnStockAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new VehiculosEnStockFilterType());

        $entities = array();

//        $reportesManager = $this->get('manager.reportes');

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosEnStock(false, $data);
            }
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
                $entities, $request->query->get('page', 1)/* page number */, 30/* limit per page */
        );

        return $this->render('VehiculosBundle:Reporte:reporteVehiculosEnStock.html.twig', array(
                    'entities' => $entities,
                    'form' => $form->createView()
        ));
    }

    public function excelReporteVehiculosEnStockAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new VehiculosEnStockFilterType());

        $entities = array();

//        $reportesManager = $this->get('manager.reportes');

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosEnStock(false, $data);
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
        $form = $this->createForm(new VehiculosEnStockFilterType());

        $entities = array();

//        $reportesManager = $this->get('manager.reportes');

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosEnStock(false, $data);
            }
        }

        $html = $this->renderView(
                'VehiculosBundle:Reporte:reporteVehiculosEnStock.pdf.twig', array(
            'entities' => $entities
                )
        );

        return new Response(
                $this->get('knp_snappy.pdf')->getOutputFromHtml($html, array(
                    'margin-left' => '1cm',
                    'margin-right' => '1cm',
                    'margin-top' => '1cm',
                    'margin-bottom' => '1cm',
                )), 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="Reporte_vehiculos_en_stock.pdf"'
                )
        );
    }

}
