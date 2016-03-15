<?php

/**
 * Created by PhpStorm.
 * User: matias
 * Date: 30/12/15
 * Time: 4:04 PM
 */

namespace VehiculosBundle\Services;

use CuestionariosBundle\Entity\CuestionarioResultadoCabecera;
use CuestionariosBundle\Entity\CuestionarioResultadoRespuesta;
use CuestionariosBundle\Entity\PreguntaResultadoRespuesta;
use Doctrine\ORM\EntityManager;
use VehiculosBundle\Entity\EstadoVehiculo;

class VehiculosManager {

    private $container;
    /* @var $em EntityManager */
    private $em;

    public function __construct($container) {
        $this->container = $container;
        $this->em = $container->get('doctrine')->getManager();
    }

    public function guardarVehiculo( $vehiculo, $tipoEstadoDanioGm = null, $daniosGmOriginal = array() ) {
        $em = $this->em;

        if ( ! $vehiculo->getRemito()->getUsuarioReceptor() ) {
            $vehiculo->getRemito()->setUsuarioReceptor( $this->container->get( 'security.token_storage' )->getToken()->getUser() );
        }
        if ( ! $vehiculo->getRemito()->getFechaRecibido() ) {
            $vehiculo->getRemito()->setFechaRecibido( new \DateTime( 'now' ) );
        }

        foreach ( $daniosGmOriginal as $item ) {
            if ( false === $vehiculo->getDanioVehiculoGm()->contains( $item ) ) {
                $em->remove( $item );
            }
        }

        if ( $vehiculo->getDanioVehiculoGm()->count() > 0 ) {

            foreach ( $vehiculo->getDanioVehiculoGm() as $danioVehiculo ) {
                $danioVehiculo->setVehiculo( $vehiculo );
                if ( $tipoEstadoDanioGm ) {
                    $danioVehiculo->setTipoEstadoDanioGm( $tipoEstadoDanioGm );
                }
                foreach ( $danioVehiculo->getFotoDanio() as $fotoDanio ) {
                    $fotoDanio->setDanioVehiculo( $danioVehiculo );
                }
            }
        }
        $tipoEstadoVehiculo = $em->getRepository( 'VehiculosBundle:TipoEstadoVehiculo' )->findOneBySlug(
            'recibido'
        );


        $this->setEstadoActualVehiculo( $vehiculo, $tipoEstadoVehiculo );

        $em->flush();

        return true;
    }

    public function crearCheckList($vehiculo, $checkList, $daniosInternoOriginal = array()) {

        $em = $this->em;

        $vehiculo = $this->modificarDanioInterno($vehiculo, $daniosInternoOriginal);

        $resultadoCabecera = new CuestionarioResultadoCabecera();
        $resultadoCabecera->setVehiculo($vehiculo);


        foreach ($checkList as $preguntaId => $valor) {
            $resultadoRespuesta = new CuestionarioResultadoRespuesta();
            $resultadoRespuesta->setResultadoCabecera($resultadoCabecera);
            $resultadoRespuesta->setTextoRespuesta($valor);

            $pregunta = $em->getRepository('CuestionariosBundle:CuestionarioPregunta')->find($preguntaId);

            $preguntaResultadoRespuesta = new PreguntaResultadoRespuesta();
            $preguntaResultadoRespuesta->setResultadoRespuesta($resultadoRespuesta);
            $preguntaResultadoRespuesta->setPregunta($pregunta);

            $em->persist($preguntaResultadoRespuesta);
        }
        $tipoVentaEspecialSlug = $vehiculo->getTipoVentaEspecial()->getSlug();
        if ($tipoVentaEspecialSlug == 'plan-de-ahorro'  || $tipoVentaEspecialSlug == 'venta-especial') {
            $slug = 'pendiente-por-entregar';
        } else {
            $slug = 'stock';
        }

        $tipoEstadoVehiculo = $em->getRepository('VehiculosBundle:TipoEstadoVehiculo')->findOneBySlug($slug);

        if ($vehiculo->getEstadoVehiculo()->last()->getTipoEstadoVehiculo() !== $tipoEstadoVehiculo) {

            $this->setEstadoActualVehiculo($vehiculo, $tipoEstadoVehiculo);
        }
        $em->flush();

        return true;
    }

    public function setEstadoActualVehiculo($vehiculo, $tipoEstadoVehiculo) {
//		$em = $this->em;
        //cambio actual=false en todos los registros de estado que tuvo el automovil
//		$qb = $em->getRepository( 'VehiculosBundle:Vehiculo' )->createQueryBuilder( 'e' )
//		         ->update( 'VehiculosBundle:EstadoVehiculo', 'e' )
//		         ->set( 'e.actual', 'false' )
//		         ->where( 'e.vehiculo=:vehiculoId' )
//		         ->setParameter( 'vehiculoId', $vehiculo );
//
//		$qb->getQuery()->getResult();

        $estadoVehiculo = new EstadoVehiculo();
        $estadoVehiculo->setTipoEstadoVehiculo($tipoEstadoVehiculo);
        $estadoVehiculo->setVehiculo($vehiculo);

        $vehiculo->addEstadoVehiculo($estadoVehiculo);
    }

	public function modificarDanioInterno( $vehiculo, $daniosInternosOriginal ) {
		$em = $this->em;


		if ( $vehiculo->getDanioVehiculoInterno()->count() > 0 ) {

			foreach ( $vehiculo->getDanioVehiculoInterno() as $danioVehiculo ) {
				$danioVehiculo->setVehiculo( $vehiculo );

				foreach ( $danioVehiculo->getFotoDanioInterno() as $fotoDanio ) {
//					$fotoDanio->upload();
					$fotoDanio->setDanioVehiculoInterno( $danioVehiculo );
				}
			}
		}

		foreach ( $daniosInternosOriginal as $item ) {
			if ( false === $vehiculo->getDanioVehiculoInterno()->contains( $item ) ) {
				$em->remove( $item );

				foreach ( $item->getFotoDanioInterno() as $fotoDanio ) {
					$fotoDanio->setDanioVehiculoInterno( null );
					$em->remove( $fotoDanio );
				}
			}
		}

		$em->persist( $vehiculo );
		$em->flush();

		return $vehiculo;
	}

}
