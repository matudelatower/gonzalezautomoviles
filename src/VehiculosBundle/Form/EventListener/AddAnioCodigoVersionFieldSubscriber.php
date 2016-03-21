<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 11/3/16
 * Time: 11:18 AM
 */

namespace VehiculosBundle\Form\EventListener;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use VehiculosBundle\Entity\NombreModelo;

class AddAnioCodigoVersionFieldSubscriber implements EventSubscriberInterface {

	private $factory;
	private $em;

	public function __construct( FormFactoryInterface $factory, EntityManager $em ) {
		$this->factory = $factory;
		$this->em      = $em;

	}

	public static function getSubscribedEvents() {
		return array(
			FormEvents::PRE_SET_DATA => 'preSetData',
			FormEvents::PRE_SUBMIT   => 'preSubmit'
		);
	}

	private function addFieldsForm( $form, $nombreModelo, $anio, $codigo, $version ) {

		$em       = $this->em;
		$aAnios   = array();
		$aCodigos = array();
		$aVersion = array();
		if ( $nombreModelo ) {

			$anios = $em->getRepository( 'VehiculosBundle:CodigoModelo' )->getAnios();
			foreach ( $anios as $item ) {
				$aAnios[ $item['anio'] ] = $item['anio'];
			}

			$codigos = $em->getRepository( 'VehiculosBundle:CodigoModelo' )->getCodigos();
			foreach ( $codigos as $item ) {
				$aCodigos[ $item['codigo'] ] = $item['codigo'];
			}

			$versions = $em->getRepository( 'VehiculosBundle:CodigoModelo' )->getVersiones();
			foreach ( $versions as $item ) {
				$aVersion[ $item['version'] ] = $item['version'];
			}

		}
		$form->add( $this->factory->createNamed( 'anio',
			'choice',
			$anio,
			array(
				'auto_initialize' => false,
				'required'        => false,
				'attr'            => array( 'class' => 'anio' ),
				'choices'         => $aAnios,
			) ) );
		$form->add( $this->factory->createNamed( 'codigo',
			'choice',
			$codigo,
			array(
				'required'        => false,
				'auto_initialize' => false,
				'attr'            => array( 'class' => 'codigo' ),
				'choices'         => $aCodigos,
			) ) );
		$form->add( $this->factory->createNamed( 'version',
			'choice',
			$version,
			array(
				'required'        => false,
				'auto_initialize' => false,
				'attr'            => array( 'class' => 'version' ),
				'choices'         => $aVersion,
			) ) );
	}

	public function preSetData( FormEvent $event ) {
		$data = $event->getData();
		$form = $event->getForm();

		if ( null === $data ) {
			$this->addFieldsForm( $form, null, null, null, null );

			return;
		}

		$accessor     = PropertyAccess::createPropertyAccessor();
		$nombreModelo = $accessor->getValue( $data, 'nombreModelo' );
//		$departamento = ( $localidad ) ? $localidad->getDepartamento() : null;
//		$provincia    = ( $departamento ) ? $departamento->getProvincia() : null;
//		$pais         = ( $provincia ) ? $provincia->getPais() : null;


		$this->addFieldsForm( $form, $nombreModelo, null, null, null );
	}

	public function preSubmit( FormEvent $event ) {
		$data = $event->getData();
		$form = $event->getForm();

		if ( null === $data ) {
			return;
		}
		$nombreModelo = array_key_exists( 'modelo', $data ) ? $data['modelo'] : null;
		$anio         = array_key_exists( 'anio', $data ) ? $data['anio'] : null;
		$codigo       = array_key_exists( 'codigo', $data ) ? $data['codigo'] : null;
		$version      = array_key_exists( 'version', $data ) ? $data['version'] : null;


		$this->addFieldsForm( $form, $nombreModelo, $anio, $codigo, $version );
	}
}