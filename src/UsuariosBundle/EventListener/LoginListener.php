<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 15/3/16
 * Time: 8:50 AM
 */

namespace UsuariosBundle\EventListener;


use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\SecurityEvents;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Listener responsible to change the redirection at the end of the password resetting
 */
class LoginListener implements EventSubscriberInterface {
	/**
	 * @var $container ContainerAware
	 */
	private $container;

	public function __construct( $container ) {
		$this->container = $container;
	}

	/**
	 * {@inheritDoc}
	 */
	public static function getSubscribedEvents() {
		return array(
			FOSUserEvents::SECURITY_IMPLICIT_LOGIN => 'onLogin',
			SecurityEvents::INTERACTIVE_LOGIN      => 'onLogin',
		);
	}

	public function onLogin( $event ) {
		// FYI
		// if ($event instanceof UserEvent) {
		//    $user = $event->getUser();
		// }
		// if ($event instanceof InteractiveLoginEvent) {
		//    $user = $event->getAuthenticationToken()->getUser();
		// }

		$session               = $this->container->get( 'session' );
		$notificacionesManager = $this->container->get( 'manager.notificaciones' );

		$usuario = $this->container->get( 'security.token_storage' )->getToken()->getUser();

		$entregas = $notificacionesManager->getNotificacionesAgenda( $usuario );

		$cantidadNotificaciones = count( $entregas );

		$session->set( 'cantidadNotificaciones', $cantidadNotificaciones );
		$session->set( 'entregas', $cantidadNotificaciones );
	}
}