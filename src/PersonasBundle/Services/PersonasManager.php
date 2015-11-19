<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 19/11/15
 * Time: 7:11 PM
 */

namespace PersonasBundle\Services;


use PersonasBundle\Form\BuscadorPersonaType;

class PersonasManager {
	private $container;
	private $em;

	public function __construct( $container ) {
		$this->container = $container;
		$this->em        = $container->get( 'doctrine' )->getManager();
	}

	public function formBuscadorPersonas( $route, $entity = null, $method = 'POST' ) {


		$form = $this->container->get( 'form.factory' )->create( new BuscadorPersonaType(),
			$entity,
			array(
				'action' => $this->container->get( 'router' )->generate( $route ),
				'method' => 'POST',
				'attr'   => array( 'class' => 'box-body' )
			) );

		$form->add( 'submit',
			'submit',
			array(
				'label' => 'Buscar',
				'attr'  => array( 'class' => 'btn btn-primary pull-right' )
			) );

		return $form;
	}
}