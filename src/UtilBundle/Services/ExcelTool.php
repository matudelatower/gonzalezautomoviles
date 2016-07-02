<?php

namespace UtilBundle\Services;

use Doctrine\ORM\EntityManager;
use Liuggio\ExcelBundle\Factory;

class ExcelTool {

    private $container;
    private $filename;
    private $title;
    private $descripcion;
    private $createby = 'Gonzalez Automóviles';
    private $doctrine;
    private $phpexcel;
    private $body;
    private $head;

    /**
     * @return mixed
     */
    public function getContainer() {
        return $this->container;
    }

    /**
     * @param mixed $container
     */
    public function setContainer($container) {
        $this->container = $container;
    }

    /**
     * @return mixed
     */
    public function getFilename() {
        return $this->filename;
    }

    /**
     * @param mixed $filename
     */
    public function setFilename($filename) {
        $this->filename = $filename;
    }

    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    /**
     * @return string
     */
    public function getCreateby() {
        return $this->createby;
    }

    /**
     * @param string $createby
     */
    public function setCreateby($createby) {
        $this->createby = $createby;
    }

    /**
     * @return mixed
     */
    public function getDoctrine() {
        return $this->doctrine;
    }

    /**
     * @param mixed $doctrine
     */
    public function setDoctrine($doctrine) {
        $this->doctrine = $doctrine;
    }

    /**
     * @return mixed
     */
    public function getPhpexcel() {
        return $this->phpexcel;
    }

    /**
     * @param mixed $phpexcel
     */
    public function setPhpexcel($phpexcel) {
        $this->phpexcel = $phpexcel;
    }

    public function __construct(Factory $phpExcel, EntityManager $doctrine) {
        $this->phpexcel = $phpExcel;
        $this->doctrine = $doctrine;

        $this->head = array(
            'allborders' =>
            array(
                'style' => 'thick',
                'color' => array('Hex' => '#000')
            )
        );
        $this->body = array(
            'allborders' =>
            array(
                'style' => 'thin',
                'color' => array('Hex' => '#000')
            )
        );
    }

    /**
     *
     * Arma la hoja para el listado de vehiculos vendidos por vendedor en un rango de
     * fecha
     *
     * @param type $resultSet
     *
     * @return type
     */
    public function buildSheetgetReporteAutosVendidosPorVendedor($resultSet) {
        $phpExcelObject = $this->phpexcel->createPHPExcelObject();
        $phpExcelObject->getProperties()->setLastModifiedBy($this->createby);
        $phpExcelObject->getProperties()->setTitle($this->title);
        $phpExcelObject->getProperties()->setDescription($this->descripcion);
        $phpExcelObject->getProperties()->setCreator($this->createby);

        $phpExcelObject->setActiveSheetIndex(0);

        $phpExcelObject->getActiveSheet()
                ->setCellValue('A1', 'N')
                ->setCellValue('B1', 'Modelo')
                ->setCellValue('C1', 'Color Vehiculo')
                ->setCellValue('D1', 'VIN')
                ->setCellValue('E1', 'Fecha Facturación');

        $phpExcelObject->getActiveSheet()->getStyle('A1:E1')->getBorders()->applyFromArray($this->head);


        $i = 2;
        $contador = 1;
        if (is_array($resultSet) && !empty($resultSet) || !is_null($resultSet)) {
            foreach ($resultSet as $entity) {
                $phpExcelObject->getActiveSheet()->setCellValue('A' . $i, $contador);
                $phpExcelObject->getActiveSheet()->setCellValue('B' . $i, $entity['modelo']);
                $phpExcelObject->getActiveSheet()->setCellValue('C' . $i, $entity['colores_vehiculos_color']);
                $phpExcelObject->getActiveSheet()->setCellValue('D' . $i, $entity['vin']);
                $phpExcelObject->getActiveSheet()->setCellValue('E' . $i, date("d-m-Y", strtotime($entity['facturas_fecha'])));
                $i ++;
                $contador++;
            }
        }

        $phpExcelObject->getActiveSheet()->getStyle('A2:E' . $i)->getBorders()->applyFromArray($this->body);

        /** autosize */
        $phpExcelObject->getActiveSheet()->getColumnDimension('A')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('B')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('C')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('D')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('E')->setAutoSize('true');

        $phpExcelObject->getActiveSheet()->setTitle($this->title);

        $writer = $this->phpexcel->createWriter($phpExcelObject, 'Excel5');
// create the response
        $response = $this->phpexcel->createStreamedResponse($writer);

        return $response;
    }

    /**
     *
     * Arma la hoja para el listado de vehiculos en stock
     *
     * @param type $resultSet
     *
     * @return type
     */
    public function buildSheetgetReporteVehiculosEnStock($resultSet) {
        $phpExcelObject = $this->phpexcel->createPHPExcelObject();
        $phpExcelObject->getProperties()->setLastModifiedBy($this->createby);
        $phpExcelObject->getProperties()->setTitle($this->title);
        $phpExcelObject->getProperties()->setDescription($this->descripcion);
        $phpExcelObject->getProperties()->setCreator($this->createby);

        $phpExcelObject->setActiveSheetIndex(0);

        $phpExcelObject->getActiveSheet()
                ->setCellValue('A1', 'N°')
                ->setCellValue('B1', 'Modelo')
                ->setCellValue('C1', 'Color Vehiculo')
                ->setCellValue('D1', 'VIN')
                ->setCellValue('E1', 'Estado')
                ->setCellValue('F1', 'Tipo Venta')
                ->setCellValue('G1', 'Fecha Fact')
                ->setCellValue('H1', 'Dias En Stock')
                ->setCellValue('I1', 'Patentado')
                ->setCellValue('J1', 'Deposito')
                ->setCellValue('K1', 'Estado pago')
                ->setCellValue('L1', 'Observacion');

        $phpExcelObject->getActiveSheet()->getStyle('A1:H1')->getBorders()->applyFromArray($this->head);


        $i = 2;
        if (is_array($resultSet) && !empty($resultSet) || !is_null($resultSet)) {
            $modelo = "";
            $contador = 1;
            foreach ($resultSet as $entity) {

                if ($modelo != $entity['nombre_modelo']) {
                    $modelo = $entity['nombre_modelo'];
                    $phpExcelObject->getActiveSheet()->setCellValue('B' . $i, $entity['nombre_modelo']);
                    $i ++;
                }
                $phpExcelObject->getActiveSheet()->setCellValue('A' . $i, $contador);
                $phpExcelObject->getActiveSheet()->setCellValue('B' . $i, $entity['modelo']);
                $phpExcelObject->getActiveSheet()->setCellValue('C' . $i, $entity['color_vehiculo']);
                $phpExcelObject->getActiveSheet()->setCellValue('D' . $i, $entity['vin']);
                $phpExcelObject->getActiveSheet()->setCellValue('E' . $i, $entity['vehiculo_estado']);
                $phpExcelObject->getActiveSheet()->setCellValue('F' . $i, $entity['tipo_venta_especial']);
                $phpExcelObject->getActiveSheet()->setCellValue('G' . $i, date('d-m-Y', strtotime($entity['fecha_emision_documento'])));
                $phpExcelObject->getActiveSheet()->setCellValue('H' . $i, $entity['dias_en_stock']);
                if ($entity['estado_patentamiento_slug'] == "patentado") {
                    $phpExcelObject->getActiveSheet()->setCellValue('I' . $i, 'SI');
                } else {
                    $phpExcelObject->getActiveSheet()->setCellValue('I' . $i, 'NO');
                }
                $phpExcelObject->getActiveSheet()->setCellValue('J' . $i, $entity['deposito_actual']);
                if ($entity['pagado']) {
                    $phpExcelObject->getActiveSheet()->setCellValue('K' . $i, 'Gonzalez');
                } else {
                    $phpExcelObject->getActiveSheet()->setCellValue('K' . $i, 'Gpat');
                }
                $phpExcelObject->getActiveSheet()->setCellValue('L' . $i, $entity['observacion']);

                $i ++;
                $contador++;
            }
        }

        $phpExcelObject->getActiveSheet()->getStyle('A2:L' . $i)->getBorders()->applyFromArray($this->body);

        /** autosize */
        $phpExcelObject->getActiveSheet()->getColumnDimension('A')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('B')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('C')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('D')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('E')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('F')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('G')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('H')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('I')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('J')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('K')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('L')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->setTitle($this->title);

        $writer = $this->phpexcel->createWriter($phpExcelObject, 'Excel5');
// create the response
        $response = $this->phpexcel->createStreamedResponse($writer);

        return $response;
    }

    /**
     *
     * Arma la hoja para el listado de entregas programadas en un rango de
     * fecha
     *
     * @param type $resultSet
     *
     * @return type
     */
    public function buildSheetgetReporteAgendaEntregas($resultSet) {
        $phpExcelObject = $this->phpexcel->createPHPExcelObject();
        $phpExcelObject->getProperties()->setLastModifiedBy($this->createby);
        $phpExcelObject->getProperties()->setTitle($this->title);
        $phpExcelObject->getProperties()->setDescription($this->descripcion);
        $phpExcelObject->getProperties()->setCreator($this->createby);
        $phpExcelObject->setActiveSheetIndex(0);
        $phpExcelObject->getActiveSheet()
                ->setCellValue('A1', 'N')
                ->setCellValue('B1', 'Modelo')
                ->setCellValue('C1', 'Color Vehiculo')
                ->setCellValue('D1', 'VIN')
                ->setCellValue('E1', 'Tipo venta')
                ->setCellValue('F1', 'Deposito')
                ->setCellValue('G1', 'Cliente')
                ->setCellValue('H1', 'Telefono')
                ->setCellValue('I1', 'Celular')
                ->setCellValue('J1', 'Vendedor')
                ->setCellValue('K1', 'Descripcion')
                ->setCellValue('L1', 'Fecha y hora');

        $phpExcelObject->getActiveSheet()->getStyle('A1:L1')->getBorders()->applyFromArray($this->head);

        $i = 2;
        $contador = 1;
        if (is_array($resultSet) && !empty($resultSet) || !is_null($resultSet)) {
            foreach ($resultSet as $entity) {
                $phpExcelObject->getActiveSheet()->setCellValue('A' . $i, $contador);
                $phpExcelObject->getActiveSheet()->setCellValue('B' . $i, $entity['modelo']);
                $phpExcelObject->getActiveSheet()->setCellValue('C' . $i, $entity['color']);
                $phpExcelObject->getActiveSheet()->setCellValue('D' . $i, $entity['vin']);
                $phpExcelObject->getActiveSheet()->setCellValue('E' . $i, $entity['tipo_venta_especial']);
                $phpExcelObject->getActiveSheet()->setCellValue('F' . $i, $entity['deposito_actual']);
                $phpExcelObject->getActiveSheet()->setCellValue('G' . $i, $entity['cliente']);
                $phpExcelObject->getActiveSheet()->setCellValue('H' . $i, $entity['telefono']);
                $phpExcelObject->getActiveSheet()->setCellValue('I' . $i, $entity['celular']);
                $phpExcelObject->getActiveSheet()->setCellValue('J' . $i, $entity['vendedor']);
                $phpExcelObject->getActiveSheet()->setCellValue('K' . $i, $entity['descripcion_entrega']);
                $phpExcelObject->getActiveSheet()->setCellValue('L' . $i, date("d-m-Y", strtotime($entity['fecha_entrega'])) . " " . $entity['hora_entrega']);

                $i ++;
                $contador++;
            }
        }

        $phpExcelObject->getActiveSheet()->getStyle('A2:L' . $i)->getBorders()->applyFromArray($this->body);

        /** autosize */
        $phpExcelObject->getActiveSheet()->getColumnDimension('A')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('B')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('C')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('D')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('E')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('F')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('G')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('H')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('I')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('J')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('K')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('L')->setAutoSize('true');

        $phpExcelObject->getActiveSheet()->setTitle($this->title);

        $writer = $this->phpexcel->createWriter($phpExcelObject, 'Excel5');
// create the response
        $response = $this->phpexcel->createStreamedResponse($writer);

        return $response;
    }

    /**
     * Arma la hoja para el listado de vehiculos con cupon de garantia
     * @param type $tipo
     * @param type $resultSet
     * @return type
     */
    public function buildSheetgetReporteVehiculosConCuponGarantia($resultSet) {
        $phpExcelObject = $this->phpexcel->createPHPExcelObject();
        $phpExcelObject->getProperties()->setLastModifiedBy($this->createby);
        $phpExcelObject->getProperties()->setTitle($this->title);
        $phpExcelObject->getProperties()->setDescription($this->descripcion);
        $phpExcelObject->getProperties()->setCreator($this->createby);

        $phpExcelObject->setActiveSheetIndex(0);

        $phpExcelObject->getActiveSheet()
                ->setCellValue('A1', 'N')
                ->setCellValue('B1', 'Modelo')
                ->setCellValue('C1', 'Color Vehiculo')
                ->setCellValue('D1', 'VIN')
                ->setCellValue('E1', 'Cupon');

        $phpExcelObject->getActiveSheet()->getStyle('A1:E1')->getBorders()->applyFromArray($this->head);


        $i = 2;
        $contador = 1;
        if (is_array($resultSet) && !empty($resultSet) || !is_null($resultSet)) {
            foreach ($resultSet as $entity) {
                $phpExcelObject->getActiveSheet()->setCellValue('A' . $i, $contador);
                $phpExcelObject->getActiveSheet()->setCellValue('B' . $i, $entity['modelo']);
                $phpExcelObject->getActiveSheet()->setCellValue('C' . $i, $entity['color_vehiculo']);
                $phpExcelObject->getActiveSheet()->setCellValue('D' . $i, $entity['vin']);
                $phpExcelObject->getActiveSheet()->setCellValue('E' . $i, $entity['cupon_garantia']);
                $i ++;
                $contador++;
            }
        }

        $phpExcelObject->getActiveSheet()->getStyle('A2:E' . $i)->getBorders()->applyFromArray($this->body);

        /** autosize */
        $phpExcelObject->getActiveSheet()->getColumnDimension('A')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('B')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('C')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('D')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('E')->setAutoSize('true');

        $phpExcelObject->getActiveSheet()->setTitle($this->title);

        $writer = $this->phpexcel->createWriter($phpExcelObject, 'Excel5');
// create the response
        $response = $this->phpexcel->createStreamedResponse($writer);

        return $response;
    }

    /**
     * Arma la hoja para el listado de vehiculos sin cupon de garantia
     * @param type $tipo
     * @param type $resultSet
     * @return type
     */
    public function buildSheetgetReporteVehiculosSinCuponGarantia($resultSet) {
        $phpExcelObject = $this->phpexcel->createPHPExcelObject();
        $phpExcelObject->getProperties()->setLastModifiedBy($this->createby);
        $phpExcelObject->getProperties()->setTitle($this->title);
        $phpExcelObject->getProperties()->setDescription($this->descripcion);
        $phpExcelObject->getProperties()->setCreator($this->createby);

        $phpExcelObject->setActiveSheetIndex(0);

        $phpExcelObject->getActiveSheet()
                ->setCellValue('A1', 'Id')
                ->setCellValue('B1', 'Modelo')
                ->setCellValue('C1', 'Color Vehiculo')
                ->setCellValue('D1', 'VIN');

        $phpExcelObject->getActiveSheet()->getStyle('A1:D1')->getBorders()->applyFromArray($this->head);


        $i = 2;
        if (is_array($resultSet) && !empty($resultSet) || !is_null($resultSet)) {
            foreach ($resultSet as $entity) {
                $phpExcelObject->getActiveSheet()->setCellValue('A' . $i, $entity['id']);
                $phpExcelObject->getActiveSheet()->setCellValue('B' . $i, $entity['modelo']);
                $phpExcelObject->getActiveSheet()->setCellValue('C' . $i, $entity['color_vehiculo']);
                $phpExcelObject->getActiveSheet()->setCellValue('D' . $i, $entity['vin']);
                $i ++;
            }
        }

        $phpExcelObject->getActiveSheet()->getStyle('A2:D' . $i)->getBorders()->applyFromArray($this->body);

        /** autosize */
        $phpExcelObject->getActiveSheet()->getColumnDimension('A')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('B')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('C')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('D')->setAutoSize('true');

        $phpExcelObject->getActiveSheet()->setTitle($this->title);

        $writer = $this->phpexcel->createWriter($phpExcelObject, 'Excel5');
// create the response
        $response = $this->phpexcel->createStreamedResponse($writer);

        return $response;
    }

    /**
     * Arma la hoja para el listado de vehiculos recibidos con danios
     * @param type $tipo
     * @param type $resultSet
     * @return type
     */
    public function buildSheetReporteVehiculosRecibidosConDanios($resultSet) {
        $phpExcelObject = $this->phpexcel->createPHPExcelObject();
        $phpExcelObject->getProperties()->setLastModifiedBy($this->createby);
        $phpExcelObject->getProperties()->setTitle($this->title);
        $phpExcelObject->getProperties()->setDescription($this->descripcion);
        $phpExcelObject->getProperties()->setCreator($this->createby);

        $phpExcelObject->setActiveSheetIndex(0);

        $phpExcelObject->getActiveSheet()
                ->setCellValue('A1', 'Total de Vehículos Recibidos')
                ->setCellValue('A2', 'Vehiculos Recibidos con Daños')
                ->setCellValue('A3', 'Vehiculos Recibidos sin Daños')
                ->setCellValue('A4', '% Vehiculos Recibidos con Daños')
                ->setCellValue('A5', '% Vehiculos Recibidos sin Daños');

        $phpExcelObject->getActiveSheet()->getStyle('A1:B1')->getBorders()->applyFromArray($this->head);


        $i = 2;
        $phpExcelObject->getActiveSheet()->setCellValue('B1', $resultSet['autosRecibidos']);
        $phpExcelObject->getActiveSheet()->setCellValue('B2', $resultSet['autosRecibidosConDanos']);
        $phpExcelObject->getActiveSheet()->setCellValue('B3', $resultSet['autosRecibidosSinDanos']);
        $phpExcelObject->getActiveSheet()->setCellValue('B4', ( $resultSet['autosRecibidosConDanos'] * 100 / $resultSet['autosRecibidos'] ) . "%");
        $phpExcelObject->getActiveSheet()->setCellValue('B5', ( $resultSet['autosRecibidosSinDanos'] * 100 / $resultSet['autosRecibidos'] ) . "%");

        $phpExcelObject->getActiveSheet()->getStyle('A2:B' . $i)->getBorders()->applyFromArray($this->body);

        /** autosize */
        $phpExcelObject->getActiveSheet()->getColumnDimension('A')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('B')->setAutoSize('true');

        $phpExcelObject->getActiveSheet()->setTitle($this->title);

        $writer = $this->phpexcel->createWriter($phpExcelObject, 'Excel5');
// create the response
        $response = $this->phpexcel->createStreamedResponse($writer);

        return $response;
    }

    /**
     *
     * Arma la hoja para el listado de vehiculos por deposito
     *
     * @param type $resultSet
     *
     * @return type
     */
    public function buildSheetgetReporteVehiculosPorDeposito($resultSet) {
        $phpExcelObject = $this->phpexcel->createPHPExcelObject();
        $phpExcelObject->getProperties()->setLastModifiedBy($this->createby);
        $phpExcelObject->getProperties()->setTitle($this->title);
        $phpExcelObject->getProperties()->setDescription($this->descripcion);
        $phpExcelObject->getProperties()->setCreator($this->createby);

        $phpExcelObject->setActiveSheetIndex(0);

        $phpExcelObject->getActiveSheet()
                ->setCellValue('A1', 'N°')
                ->setCellValue('B1', 'Modelo')
                ->setCellValue('C1', 'Color Vehiculo')
                ->setCellValue('D1', 'VIN')
                ->setCellValue('E1', 'Tipo de venta especial')
                ->setCellValue('F1', 'Deposito');

        $phpExcelObject->getActiveSheet()->getStyle('A1:F1')->getBorders()->applyFromArray($this->head);


        $i = 2;
        $contador = 1;
        if (is_array($resultSet) && !empty($resultSet) || !is_null($resultSet)) {
            $modelo = "";
            foreach ($resultSet as $entity) {

                if ($modelo != $entity['nombre_modelo']) {
                    $modelo = $entity['nombre_modelo'];
                    $phpExcelObject->getActiveSheet()->setCellValue('B' . $i, $entity['nombre_modelo']);
                    $i ++;
                }
                $phpExcelObject->getActiveSheet()->setCellValue('A' . $i, $contador);
                $phpExcelObject->getActiveSheet()->setCellValue('B' . $i, $entity['modelo']);
                $phpExcelObject->getActiveSheet()->setCellValue('C' . $i, $entity['color_vehiculo']);
                $phpExcelObject->getActiveSheet()->setCellValue('D' . $i, $entity['vin']);
                $phpExcelObject->getActiveSheet()->setCellValue('E' . $i, $entity['tipo_venta_especial']);
                $phpExcelObject->getActiveSheet()->setCellValue('F' . $i, $entity['deposito_actual']);
                $i ++;
                $contador++;
            }
        }

        $phpExcelObject->getActiveSheet()->getStyle('A2:F' . $i)->getBorders()->applyFromArray($this->body);

        /** autosize */
        $phpExcelObject->getActiveSheet()->getColumnDimension('A')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('B')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('C')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('D')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('E')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('F')->setAutoSize('true');

        $phpExcelObject->getActiveSheet()->setTitle($this->title);

        $writer = $this->phpexcel->createWriter($phpExcelObject, 'Excel5');
// create the response
        $response = $this->phpexcel->createStreamedResponse($writer);

        return $response;
    }

    /**
     *
     * Arma la hoja para el listado de vehiculos asignados a un reventa
     *
     * @param type $resultSet
     *
     * @return type
     */
    public function buildSheetReporteVehiculosAsignadosAReventa($resultSet) {
        $phpExcelObject = $this->phpexcel->createPHPExcelObject();
        $phpExcelObject->getProperties()->setLastModifiedBy($this->createby);
        $phpExcelObject->getProperties()->setTitle($this->title);
        $phpExcelObject->getProperties()->setDescription($this->descripcion);
        $phpExcelObject->getProperties()->setCreator($this->createby);

        $phpExcelObject->setActiveSheetIndex(0);

        $phpExcelObject->getActiveSheet()
                ->setCellValue('A1', 'N°')
                ->setCellValue('B1', 'Modelo')
                ->setCellValue('C1', 'Color vehiculo')
                ->setCellValue('D1', 'Vin')
                ->setCellValue('E1', 'Facturado')
                ->setCellValue('F1', 'Estado Patentamiento')
                ->setCellValue('G1', 'Dias de recibido')
                ->setCellValue('H1', 'Observacion')
        ;

        $phpExcelObject->getActiveSheet()->getStyle('A1:H1')->getBorders()->applyFromArray($this->head);


        $i = 2;
        $contador = 1;
        if (is_array($resultSet) && !empty($resultSet) || !is_null($resultSet)) {

            foreach ($resultSet as $entity) {

                $phpExcelObject->getActiveSheet()->setCellValue('A' . $i, $contador);
                $phpExcelObject->getActiveSheet()->setCellValue('B' . $i, $entity['modelo']);
                $phpExcelObject->getActiveSheet()->setCellValue('C' . $i, $entity['color_vehiculo']);
                $phpExcelObject->getActiveSheet()->setCellValue('D' . $i, $entity['vin']);
                $phpExcelObject->getActiveSheet()->setCellValue('E' . $i, $entity['factura_id'] ? 'SI' : 'NO');
                $phpExcelObject->getActiveSheet()->setCellValue('F' . $i, $entity['estado_patentamiento'] ? $entity['estado_patentamiento'] : '');
                $phpExcelObject->getActiveSheet()->setCellValue('G' . $i, $entity['dias_de_recibido']);
                $phpExcelObject->getActiveSheet()->setCellValue('H' . $i, $entity['observacion']);

                $i ++;
                $contador++;
            }
        }

        $phpExcelObject->getActiveSheet()->getStyle('A2:H' . $i)->getBorders()->applyFromArray($this->body);

        /** autosize */
        $phpExcelObject->getActiveSheet()->getColumnDimension('A')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('B')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('C')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('D')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('E')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('F')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('G')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('H')->setAutoSize('true');

        $phpExcelObject->getActiveSheet()->setTitle($this->title);

        $writer = $this->phpexcel->createWriter($phpExcelObject, 'Excel5');
// create the response
        $response = $this->phpexcel->createStreamedResponse($writer);

        return $response;
    }

    public function buildSheetReporteVehiculosPatentamientos($resultSet) {
        $phpExcelObject = $this->phpexcel->createPHPExcelObject();
        $phpExcelObject->getProperties()->setLastModifiedBy($this->createby);
        $phpExcelObject->getProperties()->setTitle($this->title);
        $phpExcelObject->getProperties()->setDescription($this->descripcion);
        $phpExcelObject->getProperties()->setCreator($this->createby);

        $phpExcelObject->setActiveSheetIndex(0);

        $phpExcelObject->getActiveSheet()
                ->setCellValue('A1', 'N°')
                ->setCellValue('B1', 'Cliente')
                ->setCellValue('C1', 'Modelo')
                ->setCellValue('D1', 'VIN')
                ->setCellValue('E1', 'Tipo venta')
                ->setCellValue('F1', 'Agente inicio pat.')
                ->setCellValue('G1', 'Fecha inicio')
                ->setCellValue('H1', 'Dominio')
                ->setCellValue('I1', 'Fecha patent.')
                ->setCellValue('J1', 'N° registro')
                ->setCellValue('K1', 'Tel cliente');

        $phpExcelObject->getActiveSheet()->getStyle('A1:K1')->getBorders()->applyFromArray($this->head);


        $i = 2;
        if (is_array($resultSet) && !empty($resultSet) || !is_null($resultSet)) {
            $contador = 1;
            foreach ($resultSet as $entity) {

                $phpExcelObject->getActiveSheet()->setCellValue('A' . $i, $contador);
                $phpExcelObject->getActiveSheet()->setCellValue('B' . $i, $entity['cliente']);
                $phpExcelObject->getActiveSheet()->setCellValue('C' . $i, $entity['modelo']);
                $phpExcelObject->getActiveSheet()->setCellValue('D' . $i, $entity['vin']);
                $phpExcelObject->getActiveSheet()->setCellValue('E' . $i, $entity['tipo_venta_especial']);
                $phpExcelObject->getActiveSheet()->setCellValue('F' . $i, $entity['agente_patentamiento']);
                $phpExcelObject->getActiveSheet()->setCellValue('G' . $i, $entity['fecha_inicio']);
                $phpExcelObject->getActiveSheet()->setCellValue('H' . $i, $entity['dominio']);
                $phpExcelObject->getActiveSheet()->setCellValue('I' . $i, $entity['fecha_patentamiento']);
                $phpExcelObject->getActiveSheet()->setCellValue('J' . $i, $entity['registro']);
                $phpExcelObject->getActiveSheet()->setCellValue('K' . $i, $entity['celular']);
                $i ++;
                $contador++;
            }
        }

        $phpExcelObject->getActiveSheet()->getStyle('A2:K' . $i)->getBorders()->applyFromArray($this->body);

        /** autosize */
        $phpExcelObject->getActiveSheet()->getColumnDimension('A')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('B')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('C')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('D')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('E')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('F')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('G')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('H')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('I')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('J')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('K')->setAutoSize('true');

        $phpExcelObject->getActiveSheet()->setTitle($this->title);

        $writer = $this->phpexcel->createWriter($phpExcelObject, 'Excel5');
// create the response
        $response = $this->phpexcel->createStreamedResponse($writer);

        return $response;
    }
/*
 * devuelve los vehiculos con daños de gm
 */
    public function buildSheetReporteVehiculosDaniosGm($resultSet) {
        $phpExcelObject = $this->phpexcel->createPHPExcelObject();
        $phpExcelObject->getProperties()->setLastModifiedBy($this->createby);
        $phpExcelObject->getProperties()->setTitle($this->title);
        $phpExcelObject->getProperties()->setDescription($this->descripcion);
        $phpExcelObject->getProperties()->setCreator($this->createby);

        $phpExcelObject->setActiveSheetIndex(0);

        $phpExcelObject->getActiveSheet()
                ->setCellValue('A1', 'N°')
                ->setCellValue('B1', 'Modelo')
                ->setCellValue('C1', 'Color')
                ->setCellValue('D1', 'VIN')
                ->setCellValue('E1', 'Deposito')
                ->setCellValue('F1', 'Danios');

        $phpExcelObject->getActiveSheet()->getStyle('A1:E1')->getBorders()->applyFromArray($this->head);


        $i = 2;
        if (is_array($resultSet) && !empty($resultSet) || !is_null($resultSet)) {
            $contador = 1;

            foreach ($resultSet as $entity) {
                $danios = null;
                $phpExcelObject->getActiveSheet()->setCellValue('A' . $i, $contador);
                $phpExcelObject->getActiveSheet()->setCellValue('B' . $i, $entity['nombre_modelo'] . " | " . $entity['anio_modelo'] . " | " . $entity['version']);
                $phpExcelObject->getActiveSheet()->setCellValue('C' . $i, $entity['color']);
                $phpExcelObject->getActiveSheet()->setCellValue('D' . $i, $entity['vin']);
                $phpExcelObject->getActiveSheet()->setCellValue('E' . $i, $entity['deposito']);

                foreach ($entity['danios'] as $danio) {
                    $danios.=" ["
                            . $danio['tipo_danio'] . "-"
                            . $danio['codigo_danio'] . "-"
                            . $danio['descripcion']
                            . "] ";
                }

                $phpExcelObject->getActiveSheet()->setCellValue('F' . $i, $danios);
                $i ++;
                $contador++;
            }
        }

        $phpExcelObject->getActiveSheet()->getStyle('A2:F' . $i)->getBorders()->applyFromArray($this->body);

        /** autosize */
        $phpExcelObject->getActiveSheet()->getColumnDimension('A')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('B')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('C')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('D')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('E')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('F')->setAutoSize('true');

        $phpExcelObject->getActiveSheet()->setTitle($this->title);

        $writer = $this->phpexcel->createWriter($phpExcelObject, 'Excel5');
// create the response
        $response = $this->phpexcel->createStreamedResponse($writer);

        return $response;
    }
    
    /*
 * devuelve los vehiculos con daños internos
 */
    public function buildSheetReporteVehiculosDaniosInternos($resultSet) {
        $phpExcelObject = $this->phpexcel->createPHPExcelObject();
        $phpExcelObject->getProperties()->setLastModifiedBy($this->createby);
        $phpExcelObject->getProperties()->setTitle($this->title);
        $phpExcelObject->getProperties()->setDescription($this->descripcion);
        $phpExcelObject->getProperties()->setCreator($this->createby);

        $phpExcelObject->setActiveSheetIndex(0);

        $phpExcelObject->getActiveSheet()
                ->setCellValue('A1', 'N°')
                ->setCellValue('B1', 'Modelo')
                ->setCellValue('C1', 'Color')
                ->setCellValue('D1', 'VIN')
                ->setCellValue('E1', 'Deposito')
                ->setCellValue('F1', 'Danios');

        $phpExcelObject->getActiveSheet()->getStyle('A1:E1')->getBorders()->applyFromArray($this->head);


        $i = 2;
        if (is_array($resultSet) && !empty($resultSet) || !is_null($resultSet)) {
            $contador = 1;

            foreach ($resultSet as $entity) {
                $danios = null;
                $phpExcelObject->getActiveSheet()->setCellValue('A' . $i, $contador);
                $phpExcelObject->getActiveSheet()->setCellValue('B' . $i, $entity['nombre_modelo'] . " | " . $entity['anio_modelo'] . " | " . $entity['version']);
                $phpExcelObject->getActiveSheet()->setCellValue('C' . $i, $entity['color']);
                $phpExcelObject->getActiveSheet()->setCellValue('D' . $i, $entity['vin']);
                $phpExcelObject->getActiveSheet()->setCellValue('E' . $i, $entity['deposito']);

                foreach ($entity['danios'] as $danio) {
                    if($danio['solucionado']=='t'){
                        $solucionado="Solucionado:SI";
                    }else{
                        $solucionado="Solucionado:NO";
                    }
                    $danios.=" ["
                            . $danio['categoria_danio'] . "-"
                            . $danio['tipo_danio'] . "-"
                            . $danio['detalle']. "-"
                            . $solucionado
                            . "] ";
                }

                $phpExcelObject->getActiveSheet()->setCellValue('F' . $i, $danios);
                $i ++;
                $contador++;
            }
        }

        $phpExcelObject->getActiveSheet()->getStyle('A2:F' . $i)->getBorders()->applyFromArray($this->body);

        /** autosize */
        $phpExcelObject->getActiveSheet()->getColumnDimension('A')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('B')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('C')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('D')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('E')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('F')->setAutoSize('true');

        $phpExcelObject->getActiveSheet()->setTitle($this->title);

        $writer = $this->phpexcel->createWriter($phpExcelObject, 'Excel5');
// create the response
        $response = $this->phpexcel->createStreamedResponse($writer);

        return $response;
    }

}
