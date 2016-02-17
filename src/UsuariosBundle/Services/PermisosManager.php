<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 17/2/16
 * Time: 6:18 PM
 */

namespace UsuariosBundle\Services;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class PermisosManager {

	private $em;
	private $router;

	public function getRouter() {
		return $this->router;
	}

	public function getEm() {
		return $this->em;
	}

	public function __construct( $em , $router) {
		$this->em = $em;
		$this->router = $router;
	}

	public function checkPermiso( $requestUri, $usuario ) {

		$em            = $this->getEm();
		$usuarioGrupos = $em->getRepository(
			'UsuariosBundle:UsuarioGrupo'
		)->findByUsuario( $usuario );

		$grupo       = null;
		$permisosApp = array();

		foreach ( $usuarioGrupos as $usuarioGrupo ) {
			$grupo = $usuarioGrupo->getGrupo();
		}

		if ( $grupo ) {
			$permisosApp = $grupo->getPermisoAplicacion();
		}

		foreach ( $permisosApp as $permisoApp ) {
			if ( $permisoApp->getActivo() ) {
				$rutasAplicativo[] = $this->getRouter()->generate( $permisoApp->getItemAplicativo()->getRuta() );
			}
		}

		if ( ! in_array( $requestUri, $rutasAplicativo ) ) {
			throw new AccessDeniedException();
		}else{
			return true;
		}
	}

}