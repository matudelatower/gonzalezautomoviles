<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware {
	public function mainMenu( FactoryInterface $factory, array $options ) {
		$menu = $factory->createItem(
			'root',
			array(
				'childrenAttributes' => array(
					'class' => 'sidebar-menu',
				),
			)
		);

		$menu->addChild(
			'MENU PRINCIPAL'
		)->setAttribute( 'class', 'header' );


//        $userManager = $this->container->get('fos_user.user_manager');
		$usuario = $this->container->get( 'security.token_storage' )->getToken()->getUser();

		$em = $this->container->get( 'doctrine.orm.entity_manager' );

		$usuarioGrupos = $em->getRepository(
			'UsuariosBundle:UsuarioGrupo'
		)->findByUsuario( $usuario );

		$grupos      = array();
		$permisosApp = array();
		$aplicativo  = array();

		foreach ( $usuarioGrupos as $usuarioGrupo ) {
			$grupos[] = $usuarioGrupo->getGrupo();
		}

		foreach ( $grupos as $grupo ) {

			$permisosApp[] = $grupo->getPermisoAplicacion();
		}
		$i = 0;
		foreach ( $permisosApp as $key => $item ) {
			foreach ( $item as $permisoApp ) {
				if ( $permisoApp->getActivo() ) {
					$aplicativo[ $permisoApp->getItemAplicativo()->getAplicativo()->getNombre() ]['icono'] =
						$permisoApp->getItemAplicativo()->getAplicativo()->getIcono();

					$aplicativo[ $permisoApp->getItemAplicativo()->getAplicativo()->getNombre() ]['hijos'][ $i ]['hijo']            = $permisoApp->getItemAplicativo()->getNombre();
					$aplicativo[ $permisoApp->getItemAplicativo()->getAplicativo()->getNombre() ]['hijos'][ $i ]['ruta']            = $permisoApp->getItemAplicativo()->getRuta();
					$aplicativo[ $permisoApp->getItemAplicativo()->getAplicativo()->getNombre() ]['hijos'][ $i ]['routeParameters'] = $permisoApp->getItemAplicativo()->getRouteParams();
					$i ++;
				}
			}
		}

		ksort( $aplicativo );
		foreach ( $aplicativo as $key => $value ) {
			$menu->addChild(
				$key,
				array(
					'childrenAttributes' => array(
						'class' => 'treeview-menu',
					),
				)
			)
			     ->setUri( '#' )
			     ->setExtra( 'icon', $value['icono'] )
			     ->setAttribute( 'class', 'treeview' );
			foreach ( $value['hijos'] as $indice => $valor ) {

				if ( $valor['routeParameters'] ) {
					$aParams = json_decode( $valor['routeParameters'], true );
					foreach ( $aParams as $paramKey => $paramValue ) {

						$menu[ $key ]
							->addChild(
								$valor['hijo'],
								array(
									'route'           => $valor['ruta'],
									'routeParameters' => array( $paramKey => $paramValue )
								)
							);
					}

				} else {
					$menu[ $key ]
						->addChild(
							$valor['hijo'],
							array(
								'route' => $valor['ruta'],
							)
						);
				}
			}

		}

		if ( $usuario->hasRole( 'ROLE_ADMIN' ) ) {
			//administracion
			$menu->addChild(
				'Administracion',
				array(
					'childrenAttributes' => array(
						'class' => 'treeview-menu',
					),
				)
			)
			     ->setUri( '#' )
			     ->setExtra( 'icon', 'fa fa-dashboard' )
			     ->setAttribute( 'class', 'treeview' );

			$menu['Administracion']
				->addChild(
					'Aplicativos',
					array(
						'route' => 'aplicativo',
					)
				);
			$menu['Administracion']
				->addChild(
					'Item Aplicativos',
					array(
						'route' => 'item_aplicativo',
					)
				);

//        Usuarios
			$menu->addChild(
				'Usuarios',
				array(
					'childrenAttributes' => array(
						'class' => 'treeview-menu',
					),
				)
			)
			     ->setUri( '#' )
			     ->setExtra( 'icon', 'fa fa-user' )
			     ->setAttribute( 'class', 'treeview' );

			$menu['Usuarios']
				->addChild(
					'Listado',
					array(
						'route' => 'usuario',
					)
				);
			$menu['Usuarios']
				->addChild(
					'Grupos',
					array(
						'route' => 'fos_user_group_list',
					)
				);
			$menu['Usuarios']
				->addChild(
					'Permisos Especiales',
					array(
						'route' => 'permiso_especial',
					)
				);
		}

		return $menu;
	}
}