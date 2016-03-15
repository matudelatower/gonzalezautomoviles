<?php
namespace UsuariosBundle\EventListener;


use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use UsuariosBundle\Controller\TokenAuthenticatedController;

class TokenListener {
//	private $tokens;

	private $pm;
	private $securityContext;

	public function __construct( $pm, $securityContext ) {
		$this->pm              = $pm;
		$this->securityContext = $securityContext;
//		$this->tokens = $tokens;
	}

	public function onKernelController( FilterControllerEvent $event ) {
		$controller = $event->getController();

		/*
		 * $controller passed can be either a class or a Closure.
		 * This is not usual in Symfony but it may happen.
		 * If it is a class, it comes in array format
		 */
		if ( ! is_array( $controller ) ) {
			return;
		}

		$permisosManager = $this->pm;

		if ( $controller[0] instanceof TokenAuthenticatedController ) {
//			$requestUri =$event->getRequest()->get('_route');
			$requestUri = $event->getRequest()->getRequestUri();
			$usuario    = $this->securityContext->getToken()->getUser();
			$permisosManager->checkPermiso( $requestUri, $usuario );

		}
	}
}