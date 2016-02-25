<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 24/2/16
 * Time: 5:15 PM
 */

namespace UbicacionBundle\Form\EventListener;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class AddLocalidadFieldSubscriber implements EventSubscriberInterface {

	private $factory;

	public function __construct( FormFactoryInterface $factory ) {
		$this->factory = $factory;
	}

	public static function getSubscribedEvents() {
		return array(
			FormEvents::PRE_SET_DATA => 'preSetData',
			FormEvents::PRE_SUBMIT   => 'preSubmit'
		);
	}

	private function addLocalidadForm( $form, $localidad ) {

		$form->add( $this->factory->createNamed( 'localidad',
			'entity',
			$localidad,
			array(
				'class'           => 'UbicacionBundle:Localidad',
				'auto_initialize' => false,
				'empty_value'     => 'Seleccionar',
				'mapped'          => true,
				'attr'            => array(
					'class' => 'select_localidad select2',
				),
				'query_builder'   => function ( EntityRepository $repository ) {
					$qb = $repository->createQueryBuilder( 'loc' );

					return $qb;
				}
			) ) );
	}

	public function preSetData( FormEvent $event ) {
		$data = $event->getData();
		$form = $event->getForm();

		if ( null === $data ) {
			$this->addLocalidadForm( $form);

			return;
		}

		$accessor  = PropertyAccess::createPropertyAccessor();
		$localidad = $accessor->getValue( $data, 'localidad' );

		$this->addLocalidadForm( $form, $localidad );
	}

	public function preSubmit( FormEvent $event ) {
		$data = $event->getData();
		$form = $event->getForm();

		if ( null === $data ) {
			return;
		}
		$localidad = array_key_exists( 'categoriaDanioInterno', $data ) ? $data['categoriaDanioInterno'] : null;
		$this->addLocalidadForm( $form, $localidad );
	}


}