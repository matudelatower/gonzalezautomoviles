<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 9/12/15
 * Time: 9:05 PM
 */

namespace VehiculosBundle\Entity\Repository;


use Doctrine\ORM\EntityRepository;

class CodigoDanioGmRepository extends EntityRepository {

	public function getByLike( $string, $extraParam = null ) {

		$em = $this->getEntityManager();

		$consulta = $em->createQuery( 'SELECT cd
                                          FROM VehiculosBundle:CodigoDanioGm cd
                                          WHERE upper(cd.codigo) LIKE upper(:string)
                                     ' );


		$consulta->setParameter( 'string', '%' . $string . '%' );


		$return = $consulta->getArrayResult();

		return $return;
	}
}