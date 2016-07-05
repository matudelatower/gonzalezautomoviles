<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 24/2/16
 * Time: 4:05 PM
 */

namespace CuestionariosBundle\Entity\Repository;


use Doctrine\ORM\EntityRepository;

class EncuestaResultadoRespuestaRepository extends EntityRepository {

	public function findByEncuestaResultadoCabeceraOrdenado( $encuestaResultadoCabecera ) {
		$qb = $this->createQueryBuilder( 'err' );

		$qb->join('err.encuestaPregunta', 'ec')
			->where('err.encuestaResultadoCabecera = :encuestaResultadoCabecera')
			->setParameter('encuestaResultadoCabecera', $encuestaResultadoCabecera)
			->orderBy('ec.orden', 'ASC');

		return $qb->getQuery()->getResult();
	}

}