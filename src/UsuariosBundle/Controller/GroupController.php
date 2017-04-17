<?php

namespace UsuariosBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Event\GetResponseGroupEvent;
use FOS\UserBundle\Event\FilterGroupResponseEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GroupEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\GroupController as BaseController;
use Symfony\Component\HttpFoundation\Request;

class GroupController extends BaseController {

	/**
	 * Show the new form
	 */
	public function newAction( Request $request ) {
		/** @var $groupManager \FOS\UserBundle\Model\GroupManagerInterface */
		$groupManager = $this->get( 'fos_user.group_manager' );
		/** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
		$formFactory = $this->get( 'fos_user.group.form.factory' );
		/** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
		$dispatcher = $this->get( 'event_dispatcher' );

		$group = $groupManager->createGroup( '' );

		$dispatcher->dispatch( FOSUserEvents::GROUP_CREATE_INITIALIZE, new GroupEvent( $group, $request ) );

		$form = $formFactory->createForm();
		$form->setData( $group );

		$form->handleRequest( $request );

		if ( $form->isValid() ) {

			foreach ( $group->getPermisoAplicacion() as $permisoAplicacion ) {
				$permisoAplicacion->setGrupo( $group );
			}
			if ( $group->getPermisoEspecialGrupo() ) {
				foreach ( $group->getPermisoEspecialGrupo() as $permisoEspecial ) {
					$permisoEspecial->setGrupo( $group );
				}
			}

			$event = new FormEvent( $form, $request );
			$dispatcher->dispatch( FOSUserEvents::GROUP_CREATE_SUCCESS, $event );

			$groupManager->updateGroup( $group );

			if ( null === $response = $event->getResponse() ) {
				$url      = $this->generateUrl( 'fos_user_group_show', array( 'groupName' => $group->getName() ) );
				$response = new RedirectResponse( $url );
			}

			$dispatcher->dispatch( FOSUserEvents::GROUP_CREATE_COMPLETED,
				new FilterGroupResponseEvent( $group, $request, $response ) );

			return $response;
		}

		return $this->render( 'FOSUserBundle:Group:new.html.twig',
			array(
				'form' => $form->createview(),
			) );
	}

	/**
	 * Edit one group, show the edit form
	 */
	public function editAction( Request $request, $groupName ) {
		$group = $this->findGroupBy( 'name', $groupName );

		/** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
		$dispatcher = $this->get( 'event_dispatcher' );

		$event = new GetResponseGroupEvent( $group, $request );
		$dispatcher->dispatch( FOSUserEvents::GROUP_EDIT_INITIALIZE, $event );

		if ( null !== $event->getResponse() ) {
			return $event->getResponse();
		}

		/** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
		$formFactory = $this->get( 'fos_user.group.form.factory' );

		$permisoEspecialOriginales = new ArrayCollection();

		// Crear un ArrayCollection de $permisoEspecialGrupo
		foreach ( $group->getPermisoEspecialGrupo() as $permisoEspecialGrupo ) {
			$permisoEspecialOriginales->add( $permisoEspecialGrupo );
		}

		$permisoAplicacionOriginales = new ArrayCollection();

		// Crear un ArrayCollection de $permisoAplicacion
		foreach ( $group->getPermisoAplicacion() as $permisoAplicacion ) {
			$permisoAplicacionOriginales->add( $permisoAplicacion );
		}

		$form = $formFactory->createForm();
		$form->setData( $group );

		$form->handleRequest( $request );
		$em = $this->getDoctrine()->getManager();
		if ( $form->isValid() ) {

			//elimina los permisoAplicacion
			foreach ( $permisoAplicacionOriginales as $permisoAplicacion ) {
				if ( false === $group->getPermisoAplicacion()->contains( $permisoAplicacion ) ) {

					$permisoAplicacion->setGrupo( null );
					$em->remove( $permisoAplicacion );
				}
			}

			foreach ( $group->getPermisoAplicacion() as $permisoAplicacion ) {
				$permisoAplicacion->setGrupo( $group );
			}

			//elimina los permisos especiales grupos
			foreach ( $permisoEspecialOriginales as $permisoEspecialGrupo ) {
				if ( false === $group->getPermisoEspecialGrupo()->contains( $permisoEspecialGrupo ) ) {

					$permisoEspecialGrupo->setGrupo( null );
					$em->remove( $permisoEspecialGrupo );
				}
			}

			foreach ( $group->getPermisoEspecialGrupo() as $permisoEspecial ) {
				$permisoEspecial->setGrupo( $group );
			}


			/** @var $groupManager \FOS\UserBundle\Model\GroupManagerInterface */
			$groupManager = $this->get( 'fos_user.group_manager' );

			$event = new FormEvent( $form, $request );
			$dispatcher->dispatch( FOSUserEvents::GROUP_EDIT_SUCCESS, $event );

			$groupManager->updateGroup( $group );

			if ( null === $response = $event->getResponse() ) {
				$url      = $this->generateUrl( 'fos_user_group_show', array( 'groupName' => $group->getName() ) );
				$response = new RedirectResponse( $url );
			}

			$dispatcher->dispatch(
				FOSUserEvents::GROUP_EDIT_COMPLETED,
				new FilterGroupResponseEvent( $group, $request, $response )
			);

			return $response;
		}

		return $this->render(
			'FOSUserBundle:Group:edit.html.twig',
			array(
				'form'       => $form->createview(),
				'group_name' => $group->getName(),
			)
		);
	}

}
