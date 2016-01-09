<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 9/1/16
 * Time: 7:04 PM
 */

namespace VehiculosBundle\Entity\Repository;


use Doctrine\ORM\EntityRepository;

class PreguntaResultadoRespuestaRepository extends EntityRepository {

	public function getRespuesta( $pregunta, $cabecera ) {
		$qb = $this->createQueryBuilder( 'prr' );
		$qb->join( 'prr.pregunta', 'preg' )
		   ->join( 'prr.resultadoRespuesta', 'rr' )
		   ->join( 'rr.resultadoCabecera', 'cab' )
		   ->where( 'preg = :pregunta' )
		   ->andWhere( 'cab = :cabecera' );
		$qb->setParameter( 'pregunta', $pregunta );
		$qb->setParameter( 'cabecera', $cabecera );

		return $qb->getQuery()->getResult();
	}

}