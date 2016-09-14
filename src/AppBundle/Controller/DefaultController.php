<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {
	public function indexAction() {
		return $this->render( 'AppBundle:Default:index.html.twig' );
	}

	public function pantallaVaciaAction( Request $request ) {


		return $this->render( 'AppBundle:Default:pantallaVacia.html.twig',
			array() );
	}

	public function bloquearPantallaAction( Request $request ,$vehiculoId) {
		return $this->render( 'AppBundle:Default:lockScreen.html.twig',
			array(
                            'vehiculoId'=>$vehiculoId,
                        ) );
	}

	public function desbloquearPantallaAction( Request $request ) {

		$user_manager = $this->get( 'fos_user.user_manager' );
		$factory      = $this->get( 'security.encoder_factory' );

		$userName = $request->get( 'username' );
		$password = $request->get( 'password' );

		$user = $user_manager->findUserByUsername( $userName );

		$encoder = $factory->getEncoder( $user );

		$bool = ( $encoder->isPasswordValid( $user->getPassword(), $password, $user->getSalt() ) ) ? true : false;

		if ( $bool ) {
			return $this->redirectToRoute( 'app_homepage' );
		} else {

			$this->get( 'session' )->getFlashBag()->add(
				'error',
				'Contraseña Incorrecta'
			);
		}

		return $this->render( 'AppBundle:Default:lockScreen.html.twig',
			array('vehiculoId'=>null) );


	}
}
