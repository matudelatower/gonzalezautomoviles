<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 4/4/17
 * Time: 16:24
 */

namespace CRMBundle\Repository;


use Doctrine\ORM\EntityRepository;

class EncuestaPreguntaRepository extends EntityRepository {

	public function findByEncuestaOrdenadaPorPreguntas( $encuesta ) {

		$qb = $this->createQueryBuilder( 'ep' );

		$qb->where( 'ep.encuesta = :encuesta' );
		$qb->orderBy( 'ep.orden', 'ASC' );
		$qb->setParameter( 'encuesta', $encuesta );

		return $qb->getQuery()->getResult();

	}
}