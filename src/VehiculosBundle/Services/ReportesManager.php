<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 15/2/16
 * Time: 3:49 PM
 */

namespace VehiculosBundle\Services;


use Doctrine\ORM\EntityManager;

class ReportesManager {
	private $container;
	/* @var $em EntityManager */
	private $em;

	public function __construct( $container ) {
		$this->container = $container;
		$this->em        = $container->get( 'doctrine' )->getManager();
	}

	public function getAutosVendidosPorVendedor( $vendedor, $fechaDesde = null, $fechaHasta = null ) {

		$em = $this->em;

		$aRegistros = $em->getRepository( 'VehiculosBundle:Vehiculo' )->getVendidosPorVendedor( $vendedor,
			$fechaDesde,
			$fechaHasta );

		return $aRegistros;
	}
}