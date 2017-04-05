<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 4/4/17
 * Time: 19:16
 */

namespace CRMBundle\Services;


use CRMBundle\Entity\Encuesta;
use Doctrine\ORM\EntityManager;

class CRMEncuestasManager {

	private $em;

	public function __construct( EntityManager $em ) {
		$this->em = $em;
	}


	/**
	 * @param Encuesta|int $encuesta
	 *
	 * @return Encuesta|null|object
	 */
	public function cancelarEncuesta( $encuesta ) {
		if ( $encuesta instanceof Encuesta ) {
			$encuesta->setCancelada( true );
		} elseif ( is_integer( $encuesta ) ) {
			$encuesta = $this->em->getRepository( 'CRMBundle:Encuesta' )->find( $encuesta );
			$encuesta->setCancelada( true );
		}

		$this->em->persist( $encuesta );
		$this->em->flush();

		return $encuesta;
	}
}