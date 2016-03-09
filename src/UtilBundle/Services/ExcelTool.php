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
                ->setCellValue('A1', 'Id')
                ->setCellValue('B1', 'Modelo')
                ->setCellValue('C1', 'Color Vehiculo')
                ->setCellValue('D1', 'VIN')
                ->setCellValue('E1', 'Fecha Facturación');

        $phpExcelObject->getActiveSheet()->getStyle('A1:E1')->getBorders()->applyFromArray($this->head);


        $i = 2;
        if (is_array($resultSet) && !empty($resultSet) || !is_null($resultSet)) {
            foreach ($resultSet as $entity) {
                $phpExcelObject->getActiveSheet()->setCellValue('A' . $i, $entity['id']);
                $phpExcelObject->getActiveSheet()->setCellValue('B' . $i, $entity['modelo']);
                $phpExcelObject->getActiveSheet()->setCellValue('C' . $i, $entity['colores_vehiculos_color']);
                $phpExcelObject->getActiveSheet()->setCellValue('D' . $i, $entity['vin']);
                $phpExcelObject->getActiveSheet()->setCellValue('E' . $i, $entity['facturas_fecha']);
                $i ++;
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
                ->setCellValue('E1', 'Dias En Stock')
                ->setCellValue('F1', 'Deposito')
                ->setCellValue('G1', 'Estado pago');

        $phpExcelObject->getActiveSheet()->getStyle('A1:G1')->getBorders()->applyFromArray($this->head);


        $i = 2;
        if (is_array($resultSet) && !empty($resultSet) || !is_null($resultSet)) {
            $modelo = "";
            foreach ($resultSet as $entity) {

                if ($modelo != $entity['nombre_modelo']) {
                    $contador = 1;
                    $modelo = $entity['nombre_modelo'];
                    $phpExcelObject->getActiveSheet()->setCellValue('B' . $i, $entity['nombre_modelo']);
                    $i ++;
                }
                $phpExcelObject->getActiveSheet()->setCellValue('A' . $i, $contador);
                $phpExcelObject->getActiveSheet()->setCellValue('B' . $i, $entity['modelo']);
                $phpExcelObject->getActiveSheet()->setCellValue('C' . $i, $entity['color_vehiculo']);
                $phpExcelObject->getActiveSheet()->setCellValue('D' . $i, $entity['vin']);
                $phpExcelObject->getActiveSheet()->setCellValue('E' . $i, $entity['dias_en_stock']);
                $phpExcelObject->getActiveSheet()->setCellValue('F' . $i, $entity['deposito_actual']);
                if ($entity['pagado']) {
                    $phpExcelObject->getActiveSheet()->setCellValue('G' . $i, 'Gonzalez');
                } else {
                    $phpExcelObject->getActiveSheet()->setCellValue('G' . $i, 'Gpat');
                }
                $i ++;
                $contador++;
            }
        }

        $phpExcelObject->getActiveSheet()->getStyle('A2:G' . $i)->getBorders()->applyFromArray($this->body);

        /** autosize */
        $phpExcelObject->getActiveSheet()->getColumnDimension('A')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('B')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('C')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('D')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('E')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('F')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('G')->setAutoSize('true');

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
                ->setCellValue('A1', 'Id')
                ->setCellValue('B1', 'Modelo')
                ->setCellValue('C1', 'Color Vehiculo')
                ->setCellValue('D1', 'VIN')
                ->setCellValue('E1', 'Deposito')
                ->setCellValue('F1', 'Cliente')
                ->setCellValue('G1', 'Vendedor')
                ->setCellValue('H1', 'Descripcion')
                ->setCellValue('I1', 'Fecha y hora');

        $phpExcelObject->getActiveSheet()->getStyle('A1:I1')->getBorders()->applyFromArray($this->head);

        $i = 2;
        if (is_array($resultSet) && !empty($resultSet) || !is_null($resultSet)) {
            foreach ($resultSet as $entity) {
                $phpExcelObject->getActiveSheet()->setCellValue('A' . $i, $entity['id']);
                $phpExcelObject->getActiveSheet()->setCellValue('B' . $i, $entity['modelo']);
                $phpExcelObject->getActiveSheet()->setCellValue('C' . $i, $entity['color']);
                $phpExcelObject->getActiveSheet()->setCellValue('D' . $i, $entity['vin']);
                $phpExcelObject->getActiveSheet()->setCellValue('E' . $i, $entity['deposito_actual']);
                $phpExcelObject->getActiveSheet()->setCellValue('F' . $i, $entity['cliente']);
                $phpExcelObject->getActiveSheet()->setCellValue('G' . $i, $entity['vendedor']);
                $phpExcelObject->getActiveSheet()->setCellValue('H' . $i, $entity['descripcion_entrega']);
                $phpExcelObject->getActiveSheet()->setCellValue('I' . $i, date("d-m-Y", strtotime($entity['fecha_entrega'])) . " " . $entity['hora_entrega']);

                $i ++;
            }
        }

        $phpExcelObject->getActiveSheet()->getStyle('A2:I' . $i)->getBorders()->applyFromArray($this->body);

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
                ->setCellValue('A1', 'Id')
                ->setCellValue('B1', 'Modelo')
                ->setCellValue('C1', 'Color Vehiculo')
                ->setCellValue('D1', 'VIN')
                ->setCellValue('E1', 'Cupon');

        $phpExcelObject->getActiveSheet()->getStyle('A1:E1')->getBorders()->applyFromArray($this->head);


        $i = 2;
        if (is_array($resultSet) && !empty($resultSet) || !is_null($resultSet)) {
            foreach ($resultSet as $entity) {
                $phpExcelObject->getActiveSheet()->setCellValue('A' . $i, $entity['id']);
                $phpExcelObject->getActiveSheet()->setCellValue('B' . $i, $entity['modelo']);
                $phpExcelObject->getActiveSheet()->setCellValue('C' . $i, $entity['color_vehiculo']);
                $phpExcelObject->getActiveSheet()->setCellValue('D' . $i, $entity['vin']);
                $phpExcelObject->getActiveSheet()->setCellValue('E' . $i, $entity['cupon_garantia']);
                $i ++;
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

        $phpExcelObject->getActiveSheet()->getStyle('A1:E1')->getBorders()->applyFromArray($this->head);


        $i = 2;
        if (is_array($resultSet) && !empty($resultSet) || !is_null($resultSet)) {
            $modelo = "";
            foreach ($resultSet as $entity) {

                if ($modelo != $entity['nombre_modelo']) {
                    $contador = 1;
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

        $phpExcelObject->getActiveSheet()->getStyle('A2:E' . $i)->getBorders()->applyFromArray($this->body);

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
        ;

        $phpExcelObject->getActiveSheet()->getStyle('A1:G1')->getBorders()->applyFromArray($this->head);


        $i = 2;
        $contador=1;
        if (is_array($resultSet) && !empty($resultSet) || !is_null($resultSet)) {

            foreach ($resultSet as $entity) {

                $phpExcelObject->getActiveSheet()->setCellValue('A' . $i, $contador);
                $phpExcelObject->getActiveSheet()->setCellValue('B' . $i, $entity['modelo']);
                $phpExcelObject->getActiveSheet()->setCellValue('C' . $i, $entity['color_vehiculo']);
                $phpExcelObject->getActiveSheet()->setCellValue('D' . $i, $entity['vin']);
                $phpExcelObject->getActiveSheet()->setCellValue('E' . $i, $entity['factura_id']?'SI':'NO');
                $phpExcelObject->getActiveSheet()->setCellValue('F' . $i, $entity['estado_patentamiento']? $entity['estado_patentamiento']:'');
                $phpExcelObject->getActiveSheet()->setCellValue('G' . $i, $entity['dias_de_recibido']);
                $i ++;
                $contador++;
            }
        }

        $phpExcelObject->getActiveSheet()->getStyle('A2:G' . $i)->getBorders()->applyFromArray($this->body);

        /** autosize */
        $phpExcelObject->getActiveSheet()->getColumnDimension('A')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('B')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('C')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('D')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('E')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('F')->setAutoSize('true');
        $phpExcelObject->getActiveSheet()->getColumnDimension('G')->setAutoSize('true');

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
                ->setCellValue('E1', 'Agente inicio pat.')
                ->setCellValue('F1', 'Fecha inicio')
                ->setCellValue('G1', 'Dominio')
                ->setCellValue('H1', 'Fecha patent.')
                ->setCellValue('I1', 'N° registro')
                ->setCellValue('J1', 'Tel cliente');

        $phpExcelObject->getActiveSheet()->getStyle('A1:J1')->getBorders()->applyFromArray($this->head);


        $i = 2;
        if (is_array($resultSet) && !empty($resultSet) || !is_null($resultSet)) {
            $contador = 1;
            foreach ($resultSet as $entity) {

                $phpExcelObject->getActiveSheet()->setCellValue('A' . $i, $contador);
                $phpExcelObject->getActiveSheet()->setCellValue('B' . $i, $entity['cliente']);
                $phpExcelObject->getActiveSheet()->setCellValue('C' . $i, $entity['modelo']);
                $phpExcelObject->getActiveSheet()->setCellValue('D' . $i, $entity['vin']);
                $phpExcelObject->getActiveSheet()->setCellValue('E' . $i, $entity['agente_patentamiento']);
                $phpExcelObject->getActiveSheet()->setCellValue('F' . $i, $entity['fecha_inicio']);
                $phpExcelObject->getActiveSheet()->setCellValue('G' . $i, $entity['dominio']);
                $phpExcelObject->getActiveSheet()->setCellValue('H' . $i, $entity['fecha_patentamiento']);
                $phpExcelObject->getActiveSheet()->setCellValue('I' . $i, $entity['registro']);
                $phpExcelObject->getActiveSheet()->setCellValue('J' . $i, $entity['celular']);
                $i ++;
                $contador++;
            }
        }

        $phpExcelObject->getActiveSheet()->getStyle('A2:J' . $i)->getBorders()->applyFromArray($this->body);

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

        $phpExcelObject->getActiveSheet()->setTitle($this->title);

        $writer = $this->phpexcel->createWriter($phpExcelObject, 'Excel5');
// create the response
        $response = $this->phpexcel->createStreamedResponse($writer);

        return $response;
    }

}
