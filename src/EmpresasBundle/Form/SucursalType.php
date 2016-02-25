<?php

namespace EmpresasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UbicacionBundle\Form\EventListener\AddDepartamentoFieldSubscriber;
use UbicacionBundle\Form\EventListener\AddLocalidadFieldSubscriber;
use UbicacionBundle\Form\EventListener\AddPaisFieldSubscriber;
use UbicacionBundle\Form\EventListener\AddProvinciaFieldSubscriber;

class SucursalType extends AbstractType {
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$factory = $builder->getFormFactory();
		$builder
			->add( 'nombre' )
			->add( 'calle' )
			->add( 'numeroCalle' )
			->add( 'telefono1' )
			->add( 'telefono2' )
			->add( 'mail' )
			->add( 'web' )
			->add( 'empresa' );
		$builder->addEventSubscriber( new AddPaisFieldSubscriber( $factory ) );
		$builder->addEventSubscriber( new AddProvinciaFieldSubscriber( $factory ) );
		$builder->addEventSubscriber( new AddDepartamentoFieldSubscriber( $factory ) );
		$builder->addEventSubscriber( new AddLocalidadFieldSubscriber( $factory ) );
	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'data_class' => 'EmpresasBundle\Entity\Sucursal'
		) );
	}

	/**
	 * @return string
	 */
	public function getName() {
		return 'empresasbundle_sucursal';
	}
}
