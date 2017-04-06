<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 6/4/17
 * Time: 16:53
 */

namespace CRMBundle\Repository;


use Doctrine\ORM\EntityRepository;

class EncuestaResultadoCabeceraRepository extends EntityRepository {
	public function findByEncuestaNoCancelada( $encuesta ) {

		$qb = $this->createQueryBuilder( 'erc' );


		$qb->join( 'erc.encuesta', 'e' )
		   ->where( "e = :encuesta" )
		   ->setParameter( 'encuesta', $encuesta )
		   ->andWhere( $qb->expr()->andx(
			   $qb->expr()->isNull( 'erc.cancelada' )
		   ) );

		return $qb->getQuery()->getResult();

	}
}