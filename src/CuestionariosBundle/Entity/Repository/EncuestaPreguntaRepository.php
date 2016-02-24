<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 24/2/16
 * Time: 4:13 PM
 */

namespace CuestionariosBundle\Entity\Repository;


use Doctrine\ORM\EntityRepository;

class EncuestaPreguntaRepository extends EntityRepository {

	public function findByEncuestaOrdenado( $encuesta, $orden = 'ASC' ) {
		$qb = $this->createQueryBuilder( 'ep' );

		$qb->where( 'ep.encuesta = :encuesta' )
		   ->setParameter( 'encuesta', $encuesta )
		   ->orderBy( 'ep.orden', $orden );

		return $qb->getQuery()->getResult();
	}

}