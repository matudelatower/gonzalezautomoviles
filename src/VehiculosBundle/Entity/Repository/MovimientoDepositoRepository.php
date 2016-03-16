<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 15/3/16
 * Time: 9:13 PM
 */

namespace VehiculosBundle\Entity\Repository;


use Doctrine\ORM\EntityRepository;
use VehiculosBundle\Entity\Vehiculo;

class MovimientoDepositoRepository extends EntityRepository {


	public function getUltimoMovimientoDepositoPorVehiculo( Vehiculo $vehiculo ) {

		$qb = $this->createQueryBuilder( 'md' );

		$qb->where( 'md.vehiculo= :vehiculo' )
		   ->setParameter( 'vehiculo', $vehiculo )
		   ->orderBy( 'md.id', 'DESC' )
		   ->setMaxResults(1);

		return $qb->getQuery()->getResult();

	}
}