<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 30/12/15
 * Time: 4:04 PM
 */

namespace VehiculosBundle\Services;


use Doctrine\ORM\EntityManager;
use VehiculosBundle\Entity\EstadoVehiculo;

class VehiculosManager {

	private $container;
	/* @var $em EntityManager */
	private $em;

	public function __construct( $container ) {
		$this->container = $container;
		$this->em        = $container->get( 'doctrine' )->getManager();
	}

	public function guardarVehiculo( $vehiculo, $tipoEstadoDanioGm = null ) {
		$em = $this->em;

		if ( ! $vehiculo->getRemito()->getUsuarioReceptor() ) {
			$vehiculo->getRemito()->setUsuarioReceptor( $this->getUser() );
		}
		if ( ! $vehiculo->getRemito()->getFechaRecibido() ) {
			$vehiculo->getRemito()->setFechaRecibido( new \DateTime( 'now' ) );
		}

		if ( $vehiculo->getDanioVehiculoGm()->count() > 0 ) {

			foreach ( $vehiculo->getDanioVehiculoGm() as $danioVehiculo ) {
				$danioVehiculo->setVehiculo( $vehiculo );
				if ( $tipoEstadoDanioGm ) {
					$danioVehiculo->setTipoEstadoDanioGm( $tipoEstadoDanioGm );
				}
				foreach ( $danioVehiculo->getFotoDanio() as $fotoDanio ) {
					$fotoDanio->upload();
					$fotoDanio->setDanioVehiculo( $danioVehiculo );
				}
			}
//estado 2
			$tipoEstadoVehiculo = $em->getRepository( 'VehiculosBundle:TipoEstadoVehiculo' )->findOneBySlug(
				'recibido-con-problemas'
			);
		} else {
//estado 3
			$tipoEstadoVehiculo = $em->getRepository( 'VehiculosBundle:TipoEstadoVehiculo' )->findOneBySlug(
				'recibido-conforme'
			);
		}
		//cambio actual=false en todos los registros de estado que tuvo el automovil
		$qb = $em->getRepository( 'VehiculosBundle:Vehiculo' )->createQueryBuilder( 'e' )
		         ->update( 'VehiculosBundle:EstadoVehiculo', 'e' )
		         ->set( 'e.actual', 'false' )
		         ->where( 'e.vehiculo=:vehiculoId' )
		         ->setParameter( 'vehiculoId', $vehiculo );

		$qb->getQuery()->getResult();

		$estadoVehiculo = new EstadoVehiculo();
		$estadoVehiculo->setTipoEstadoVehiculo( $tipoEstadoVehiculo );
		$estadoVehiculo->setVehiculo( $vehiculo );
		$estadoVehiculo->setActual( 'true' );


		$vehiculo->addEstadoVehiculo( $estadoVehiculo );

		$em->flush();

		return true;
	}


}