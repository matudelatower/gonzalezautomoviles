<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 24/2/16
 * Time: 5:18 PM
 */

namespace UbicacionBundle\Form\EventListener;


use Doctrine\ORM\EntityRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use UbicacionBundle\Entity\Localidad;


class AddDepartamentoFieldSubscriber implements EventSubscriberInterface {

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

	private function addDepartamentoForm( $form, $departamento, $localidad ) {

		$form->add( $this->factory->createNamed( 'departamento',
			'entity',
			$departamento,
			array(
				'class'           => 'UbicacionBundle:Departamento',
				'auto_initialize' => false,
				'empty_value'     => 'Seleccionar',
				'mapped'          => false,
				'attr'            => array(
					'class' => 'select_departamento select2',
				),
				'query_builder'   => function ( EntityRepository $repository ) use ( $localidad ) {
					$qb = $repository->createQueryBuilder( 'dep' );
					if ( is_numeric( $localidad ) ) {
						$qb->join( 'dep.localidad', 'localidad' )
						   ->where( 'localidad.id = :loc' )
						   ->setParameter( 'loc', $localidad );
					} elseif ( $localidad instanceof Localidad ) {
						$qb->join( 'dep.localidad', 'localidad' )
						   ->where( 'localidad = :loc' )
						   ->setParameter( 'loc', $localidad );
					}


					return $qb;
				}
			) ) );
	}

	public function preSetData( FormEvent $event ) {
		$data = $event->getData();
		$form = $event->getForm();

		if ( null === $data ) {
			$this->addDepartamentoForm( $form, null, null );

			return;
		}

		$accessor     = PropertyAccess::createPropertyAccessor();
		$localidad    = $accessor->getValue( $data, 'localidad' );
		$departamento = ( $localidad ) ? $localidad->getDepartamento() : null;
		$provincia    = ( $departamento ) ? $departamento->getProvincia() : null;
		$pais         = ( $provincia ) ? $provincia->getPais() : null;


		$this->addDepartamentoForm( $form, $departamento, $localidad );
	}

	public function preSubmit( FormEvent $event ) {
		$data = $event->getData();
		$form = $event->getForm();

		if ( null === $data ) {
			return;
		}
		$departamento = array_key_exists( 'departamento', $data ) ? $data['departamento'] : null;
		$localidad    = array_key_exists( 'localidad', $data ) ? $data['localidad'] : null;
		$this->addDepartamentoForm( $form, $departamento, $localidad );
	}


}