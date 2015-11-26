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
	public function getClienteByDni( $dni ) {
		$qb = $this->createQueryBuilder( 'c' );
		$qb
			->join( 'c.personaTipo', 'pt' )
			->join( 'pt.persona', 'pers' )
			->where( "pers.numeroDocumento like upper(:numeroDocumento)" );

		$qb->setParameter( 'numeroDocumento', '%' . $dni . '%' );

		return $qb->getQuery()->getResult();


	}
}