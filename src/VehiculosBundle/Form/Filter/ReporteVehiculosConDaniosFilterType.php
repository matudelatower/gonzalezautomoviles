<?php

namespace VehiculosBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReporteVehiculosConDaniosFilterType extends AbstractType {
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder->add( 'rango',
			'text',
			array(
				'attr' => array( 'class' => 'daterange' )
			) );
	}

	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'csrf_protection' => false
		) );
	}

	public function getName() {
		return 'vehiculos_bundle_reporte_vehiculos_con_danios_filter_type';
	}
}
