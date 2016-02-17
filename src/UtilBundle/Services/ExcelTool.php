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
	public function setContainer( $container ) {
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
	public function setFilename( $filename ) {
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
	public function setTitle( $title ) {
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
	public function setDescripcion( $descripcion ) {
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
	public function setCreateby( $createby ) {
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
	public function setDoctrine( $doctrine ) {
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
	public function setPhpexcel( $phpexcel ) {
		$this->phpexcel = $phpexcel;
	}


	public function __construct( Factory $phpExcel, EntityManager $doctrine ) {
		$this->phpexcel = $phpExcel;
		$this->doctrine = $doctrine;

		$this->head = array(
			'allborders' =>
				array(
					'style' => 'thick',
					'color' => array( 'Hex' => '#000' )
				)
		);
		$this->body = array(
			'allborders' =>
				array(
					'style' => 'thin',
					'color' => array( 'Hex' => '#000' )
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
	public function buildSheetgetReporteAutosVendidosPorVendedor( $resultSet ) {
		$phpExcelObject = $this->phpexcel->createPHPExcelObject();
		$phpExcelObject->getProperties()->setLastModifiedBy( $this->createby );
		$phpExcelObject->getProperties()->setTitle( $this->title );
		$phpExcelObject->getProperties()->setDescription( $this->descripcion );
		$phpExcelObject->getProperties()->setCreator( $this->createby );

		$phpExcelObject->setActiveSheetIndex( 0 );

		$phpExcelObject->getActiveSheet()
		               ->setCellValue( 'A1', 'Id' )
		               ->setCellValue( 'B1', 'VIN' )
		               ->setCellValue( 'C1', 'Modelo' )
		               ->setCellValue( 'D1', 'Color Vehiculo' )
		               ->setCellValue( 'E1', 'Fecha Facturación' );

		$phpExcelObject->getActiveSheet()->getStyle( 'A1:E1' )->getBorders()->applyFromArray( $this->head );


		$i = 2;
		if ( is_array( $resultSet ) && ! empty ( $resultSet ) || ! is_null( $resultSet ) ) {
			foreach ( $resultSet as $entity ) {
				$phpExcelObject->getActiveSheet()->setCellValue( 'A' . $i, $entity['id'] );
				$phpExcelObject->getActiveSheet()->setCellValue( 'B' . $i, $entity['vin'] );
				$phpExcelObject->getActiveSheet()->setCellValue( 'C' . $i, $entity['modelo'] );
				$phpExcelObject->getActiveSheet()->setCellValue( 'D' . $i, $entity['colores_vehiculos_color'] );
				$phpExcelObject->getActiveSheet()->setCellValue( 'E' . $i, $entity['facturas_fecha'] );
				$i ++;
			}

		}

		$phpExcelObject->getActiveSheet()->getStyle( 'A2:E' . $i )->getBorders()->applyFromArray( $this->body );

		/** autosize */
		$phpExcelObject->getActiveSheet()->getColumnDimension( 'A' )->setAutoSize( 'true' );
		$phpExcelObject->getActiveSheet()->getColumnDimension( 'B' )->setAutoSize( 'true' );
		$phpExcelObject->getActiveSheet()->getColumnDimension( 'C' )->setAutoSize( 'true' );
		$phpExcelObject->getActiveSheet()->getColumnDimension( 'D' )->setAutoSize( 'true' );
		$phpExcelObject->getActiveSheet()->getColumnDimension( 'E' )->setAutoSize( 'true' );

		$phpExcelObject->getActiveSheet()->setTitle( $this->title );

		$writer = $this->phpexcel->createWriter( $phpExcelObject, 'Excel5' );
		// create the response
		$response = $this->phpexcel->createStreamedResponse( $writer );

		return $response;

	}


}

