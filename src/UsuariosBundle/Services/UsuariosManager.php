<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 17/2/16
 * Time: 6:18 PM
 */

namespace UsuariosBundle\Services;

use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class UsuariosManager {

	private $em;
	/**
	 * @var $router Router
	 */
	private $router;

	public function getRouter() {
		return $this->router;
	}

	public function getEm() {
		return $this->em;
	}

	public function __construct( $em, $router ) {
		$this->em     = $em;
		$this->router = $router;
	}

	function randomPassword() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}

}