<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 4/4/17
 * Time: 16:24
 */

namespace CRMBundle\Repository;


use Doctrine\ORM\EntityRepository;

class EncuestaRepository extends EntityRepository {

	public function findOrdenado( $id ) {

		$qb = $this->createQueryBuilder( 'e' );

		$qb->join( 'e.preguntas', 'p' );
		$qb->orderBy( 'p.orden', 'ASC' );
		$qb->where( 'e.id = :encuesta_id' );
		$qb->setParameter( 'encuesta_id', $id );

		return $qb->getQuery()->getSingleResult();

	}
}