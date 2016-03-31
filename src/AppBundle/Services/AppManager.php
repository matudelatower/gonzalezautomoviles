<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 7/10/15
 * Time: 10:50 PM
 */

namespace AppBundle\Services;


use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Router;

class AppManager {

	/**
	 * @var $router Router
	 */
	private $router;

	public function __construct( $router ) {
		$this->router = $router;
	}

	/**
	 * Devuelve un array de todas las rutas disponibles del sistema
	 *
	 * @return array de rutas del sistema
	 */
	public function getARoutes() {
		$availableApiRoutes = [ ];
		foreach ( $this->router->getRouteCollection()->all() as $name => $route ) {
			if ( isset( $route->getDefaults()['_controller'] ) ) {
				if ( strpos( $name, "api_" ) !== 0 && strpos( $name, "_" ) !== 0 ) {
					$availableApiRoutes[ $name ] = $name;
				}
			}
		}

		return $availableApiRoutes;
	}

	/**
	 * Devuelve un array de rutas index del sistema
	 *
	 *
	 * @return array de las rutas
	 */
	public function getAIndexRoutes() {
		$availableApiRoutes = [ ];
		foreach ( $this->router->getRouteCollection()->all() as $name => $route ) {
			if ( isset( $route->getDefaults()['_controller'] ) ) {
				$action = explode( '::', $route->getDefaults()['_controller'] );
				$route  = $route->compile();
				if ( strpos( $name, "api_" ) !== 0 && strpos( $name, "_" ) !== 0 ) {

					if ( isset( $action[1] ) && $action[1] == 'indexAction' ) {
						$emptyVars = [ ];
						foreach ( $route->getVariables() as $v ) {
							$emptyVars[ $v ] = $v;
						}
						$url                         = $this->router->generate( $name,
							$emptyVars,
							UrlGeneratorInterface::ABSOLUTE_PATH );
						$availableApiRoutes[ $name ] = $name;
//                        $availableApiRoutes[] = ["name" => $name];
//                        $availableApiRoutes[] = ["name" => $name, "url" => $url, "variables" => $route->getVariables()];
					}
				}
			}
		}

		return $availableApiRoutes;
	}

	public function getControllers() {

		$router = $this->router;

		$collection = $router->getRouteCollection();
		$allRoutes  = $collection->all();

		$routes = array();

		$return = array();

		/** @var $params \Symfony\Component\Routing\Route */
		foreach ( $allRoutes as $route => $params ) {
			$defaults = $params->getDefaults();

			if ( isset( $defaults['_controller'] ) ) {
				if ( strpos( $route, "api_" ) !== 0 && strpos( $route, "_" ) !== 0 ) {
					$controllerAction = explode( ':', $defaults['_controller'] );
					$controller       = $controllerAction[0];
					$action = $controllerAction[2];

					$return[$controller][]=$action;

//					if ( ! isset( $routes[ $controller ] ) ) {
//						$routes[ $controller ] = array();
//					}
//
//					$routes[ $controller ][] = $route;
				}
			}
		}

		return $return;
//		$thisRoutes = isset( $routes[ get_class( $this ) ] ) ?
//			$routes[ get_class( $this ) ] : null;

//		return $thisRoutes;
	}
}