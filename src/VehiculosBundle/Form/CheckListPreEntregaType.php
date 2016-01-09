<?php

namespace VehiculosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CheckListPreEntregaType extends AbstractType {
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add( 'danioVehiculoInterno',
			'bootstrapcollection',
			array(
				'type'         => new DanioVehiculoInternoType(),
				'allow_add'    => true,
				'allow_add'    => true,
				'by_reference' => true
			) )


		;
	}

	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'data_class' => 'VehiculosBundle\Entity\Vehiculo'
		) );
	}

	public function getName() {
		return 'vehiculos_bundle_check_list_pre_entrega_type';
	}
}
