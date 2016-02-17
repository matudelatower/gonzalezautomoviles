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


	public function getEntregasVigentes( $usuario ) {
		$qb = $this->createQueryBuilder( 'ae' );
		$qb->where( 'ae.creadoPor = :creado' )
		   ->setParameter( 'creado', $usuario );

		return $qb->getQuery()->getResult();
	}
}