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


class PermisosManager {

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

//	public function checkPermiso( $requestUri, $usuario ) {
//
//		$em            = $this->getEm();
//		$usuarioGrupos = $em->getRepository(
//			'UsuariosBundle:UsuarioGrupo'
//		)->findByUsuario( $usuario );
//
//		$grupo       = null;
//		$permisosApp = array();
//
//		foreach ( $usuarioGrupos as $usuarioGrupo ) {
//			$grupo = $usuarioGrupo->getGrupo();
//		}
//
//		if ( $grupo ) {
//			$permisosApp = $grupo->getPermisoAplicacion();
//		}
//
//		foreach ( $permisosApp as $permisoApp ) {
//			if ( $permisoApp->getActivo() ) {
////				$rutasAplicativo[] = $permisoApp->getItemAplicativo()->getRuta();
//				$rutasAplicativo[] = $this->getRouter()->generate( $permisoApp->getItemAplicativo()->getRuta() );
//			}
//		}
////		$requestUri = $this->getRouter()->generate($requestUri);
////		if ( ! in_array( $requestUri, $rutasAplicativo ) ) {
//		if ( ! $this->strposa( $requestUri, $rutasAplicativo ) ) {
//			throw new AccessDeniedException();
//		} else {
//			return true;
//		}
//	}

	public function checkPermiso( $controller, $action, $usuario ) {
		$em            = $this->getEm();
		$usuarioGrupos = $em->getRepository(
			'UsuariosBundle:UsuarioGrupo'
		)->findByUsuario( $usuario );

		$grupo       = null;
		$permisosApp = array();
		$permisosEspecialesApp = array();
		$return = true;

		foreach ( $usuarioGrupos as $usuarioGrupo ) {
			$grupo = $usuarioGrupo->getGrupo();
		}

		if ( $grupo ) {
//			$permisosApp = $grupo->getPermisoAplicacion();
			$permisosEspecialesApp = $grupo->getPermisoEspecialGrupo();
		}

		foreach ( $permisosEspecialesApp as $permisoEspecialApp ) {

			$strController = $pos = strrpos( $controller, "\\" );
			$strController = $pos === false ? $controller : substr( $controller, $pos + 1 );;


//			$pos           = strrpos( $strController, ":" );
//			$strController = substr( $strController, 0, $pos );

			if ( $strController . ':' . $action === $permisoEspecialApp->getPermisoEspecial()->getController() . ":" . $permisoEspecialApp->getPermisoEspecial()->getAction() ) {
				$return = true;
				break;
			} else {
				$return = false;
			}


		}

		if ( ! $return ) {
			throw new AccessDeniedException();
		} else {
			return true;
		}
	}

	function strposa( $haystack, $needle, $offset = 0 ) {
		if ( ! is_array( $needle ) ) {
			$needle = array( $needle );
		}
		foreach ( $needle as $query ) {
			if ( strpos( $haystack, $query, $offset ) !== false ) {
				$return = false;
			} // stop on first true result
		}
		$return = true;

		return $return;
	}

}