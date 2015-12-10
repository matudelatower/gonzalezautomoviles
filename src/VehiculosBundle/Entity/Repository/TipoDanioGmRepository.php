<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 30/11/15
 * Time: 10:04 PM
 */

namespace VehiculosBundle\Entity\Repository;


use Doctrine\ORM\EntityRepository;

class TipoDanioGmRepository extends EntityRepository{
	public function getByLike($string, $extraParam = null) {

		$em = $this->getEntityManager();

		$consulta = $em->createQuery('SELECT td
                                          FROM VehiculosBundle:TipoDanioGm td
                                          WHERE upper(td.codigo) LIKE upper(:string)
                                     ');


		$consulta->setParameter('string', '%' . $string . '%');


		$return = $consulta->getArrayResult();

		return $return;
	}
}