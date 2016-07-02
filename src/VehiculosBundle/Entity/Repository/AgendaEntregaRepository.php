<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 16/2/16
 * Time: 6:29 PM
 */

namespace VehiculosBundle\Entity\Repository;


use Doctrine\ORM\EntityRepository;

class AgendaEntregaRepository extends EntityRepository {


	public function getEntregasVigentes() {
		$qb = $this->createQueryBuilder( 'ae' );
		$qb->where( 'ae.fecha >= :fecha' )  
		   ->setParameter( 'fecha', date("Y-m-d", strtotime('-2 month')) );

		return $qb->getQuery()->getResult();
	}

	public function getEntregasDelDia( $usuario ) {
		$qb = $this->createQueryBuilder( 'ae' );
		$qb->where( 'ae.fecha = :fecha' )
			->andWhere('ae.creadoPor = :usuario')
		   ->setParameter( 'fecha', date("Y-m-d") )
		   ->setParameter( 'usuario', $usuario )
		;

		return $qb->getQuery()->getResult();
	}
}