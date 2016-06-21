<?php

/**
 * Created by PhpStorm.
 * User: matias
 * Date: 11/3/16
 * Time: 5:06 PM
 */

namespace VehiculosBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class CodigoModeloRepository extends EntityRepository {

    public function getAnios($nombreModelo = null) {
        $qb = $this->createQueryBuilder('cm');

        $qb->select('cm.anio')
                ->distinct();

        if ($nombreModelo){
            $qb->where('cm.nombreModelo = :nombreModelo')
                ->setParameter('nombreModelo', $nombreModelo);
        }

        return $qb->getQuery()->getArrayResult();
    }

    public function getCodigos($nombreModelo = null) {
        $qb = $this->createQueryBuilder('cm');

        $qb->select('cm.codigo')
                ->distinct();

        if ($nombreModelo){
            $qb->where('cm.nombreModelo = :nombreModelo')
               ->setParameter('nombreModelo', $nombreModelo);
        }

        return $qb->getQuery()->getArrayResult();
    }

    public function getVersiones($nombreModelo = null) {
        $qb = $this->createQueryBuilder('cm');

        $qb->select('cm.version')
                ->distinct();

        if ($nombreModelo){
            $qb->where('cm.nombreModelo = :nombreModelo')
               ->setParameter('nombreModelo', $nombreModelo);
        }

        return $qb->getQuery()->getArrayResult();
    }

    public function getCodigosModelosFilter($filter = null) {
        $qb = $this->createQueryBuilder('cm');

        if ($filter['anio']) {
            $qb->andWhere("cm.anio = :anio");
            $qb->setParameter('anio', $filter['anio']);
        }
        if ($filter['codigo']) {
            $qb->andWhere("cm.codigo like :codigo");
            $qb->setParameter('codigo', '%' . $filter['codigo'] . '%');
        }

        if ($filter['version']) {
            $qb->andWhere('cm.version like :version');
            $qb->setParameter('version', '%' . $filter['version'] . '%');
        }
        $qb->orderBy("cm.anio","ASC");
        return $qb->getQuery()->getResult();
    }

}
