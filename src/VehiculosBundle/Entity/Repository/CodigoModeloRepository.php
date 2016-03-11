<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 11/3/16
 * Time: 5:06 PM
 */

namespace VehiculosBundle\Entity\Repository;


use Doctrine\ORM\EntityRepository;

class CodigoModeloRepository extends EntityRepository{

	public function getAnios(  ) {
		$qb=$this->createQueryBuilder('cm');

		$qb->select('cm.anio')
		->distinct();

		return $qb->getQuery()->getArrayResult();
	}
	public function getCodigos(  ) {
		$qb=$this->createQueryBuilder('cm');

		$qb->select('cm.codigo')
		->distinct();

		return $qb->getQuery()->getArrayResult();
	}
	public function getVersiones(  ) {
		$qb=$this->createQueryBuilder('cm');

		$qb->select('cm.version')
		->distinct();

		return $qb->getQuery()->getArrayResult();
	}

}