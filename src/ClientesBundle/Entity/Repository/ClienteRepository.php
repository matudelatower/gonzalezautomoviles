<?php

/**
 * Created by PhpStorm.
 * User: matias
 * Date: 25/11/15
 * Time: 8:01 PM
 */

namespace ClientesBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use PDO;

class ClienteRepository extends EntityRepository {

    public function getClienteByDni($dni) {
        $qb = $this->createQueryBuilder('c');
        $qb
                ->join('c.personaTipo', 'pt')
                ->join('pt.persona', 'pers')
                ->where("pers.numeroDocumento like upper(:numeroDocumento)");

        $qb->setParameter('numeroDocumento', '%' . $dni . '%');

        return $qb->getQuery()->getResult();
    }

    public function getClienteReventaByDni($dni) {
        $qb = $this->createQueryBuilder('c');
        $qb
                ->join('c.personaTipo', 'pt')
                ->join('pt.persona', 'pers')
                ->where("pers.numeroDocumento like upper(:numeroDocumento)")
                ->andWhere('c.reventa = :reventa');

        $qb->setParameter('numeroDocumento', '%' . $dni . '%');
        $qb->setParameter('reventa', 'TRUE');

        return $qb->getQuery()->getResult();
    }

    public function getClientesFilter($filter = null) {
        $qb = $this->createQueryBuilder('c');
        $qb
                ->join('c.personaTipo', 'pt')
                ->join('pt.persona', 'pers');

        if ($filter['numeroDocumento']) {
            $qb->andWhere("pers.numeroDocumento = :numeroDocumento");
            $qb->setParameter('numeroDocumento',  $filter['numeroDocumento'] );
        }
        if ($filter['apellido']) {
            $qb->andWhere("pers.apellido like :apellido");
            $qb->setParameter('apellido', '%' . $filter['apellido'] . '%');
        }

        if ($filter['reventa']) {
            $qb->andWhere('c.reventa = :reventa');
            $qb->setParameter('reventa', $filter['reventa']);
        }
        return $qb->getQuery()->getResult();
    }

    public function getClienteByApellido($apellido) {
        $qb = $this->createQueryBuilder('c');
        $qb
            ->join('c.personaTipo', 'pt')
            ->join('pt.persona', 'pers')
            ->where("pers.apellido like upper(:apellido)");

        $qb->setParameter('apellido', '%' . $apellido . '%');

        return $qb->getQuery()->getResult();
    }

}
