<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 9/1/16
 * Time: 10:04 AM
 */

namespace VehiculosBundle\Form\EventListener;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;


class AddCategoriaDanioInternoFieldSubscriber implements EventSubscriberInterface {

	private $factory;

	public function __construct( FormFactoryInterface $factory ) {
		$this->factory = $factory;
	}

	public static function getSubscribedEvents() {
		return array(
			FormEvents::PRE_SET_DATA => 'preSetData',
			FormEvents::PRE_SUBMIT     => 'preBind'
		);
	}

	private function addCategoriaForm( $form, $categoria ) {

		$form->add( $this->factory->createNamed( 'categoriaDanioInterno',
			'entity',
			$categoria,
			array(
				'class'           => 'VehiculosBundle:CategoriaDanioInterno',
				'auto_initialize' => false,
				'empty_value'     => 'Seleccionar',
				'mapped'          => false,
				'attr'            => array(
					'class' => 'categoria_danio_interno_select select2',
				),
				'query_builder'   => function ( EntityRepository $repository ) {
					$qb = $repository->createQueryBuilder( 'cat' );

					return $qb;
				}
			) ) );
	}

	public function preSetData( FormEvent $event ) {
		$data = $event->getData();
		$form = $event->getForm();

		if ( null === $data ) {
			$this->addCategoriaForm( $form, null, null );

			return;
		}

		$accessor  = PropertyAccess::createPropertyAccessor();
		$categoria = $accessor->getValue( $data->getTipoDanioInterno(), 'categoriaDanioInterno' );

		$this->addCategoriaForm( $form, $categoria );
	}

	public function preBind( FormEvent $event ) {
		$data = $event->getData();
		$form = $event->getForm();

		if ( null === $data ) {
			return;
		}
		$categoria = array_key_exists( 'categoriaDanioInterno', $data ) ? $data['categoriaDanioInterno'] : null;
		$this->addCategoriaForm( $form, $categoria );
	}


}