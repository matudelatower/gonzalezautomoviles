<?php

namespace VehiculosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovimientoDepositoType extends AbstractType {
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add( 'fechaIngreso' )
//            ->add('fechaEgreso')
			->add( 'fila' )
			->add( 'posicion' )
			->add( 'observacion' )
			->add( 'depositoDestino',
				'entity',
				array(
					'class'    => 'VehiculosBundle:Deposito',
					'choice_label' => 'nombre',
				) )
			->add( 'tipoMovimiento' )
			->add( 'vehiculo' );
	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'data_class' => 'VehiculosBundle\Entity\MovimientoDeposito'
		) );
	}

	/**
	 * @return string
	 */
	public function getName() {
		return 'vehiculosbundle_movimientodeposito';
	}
}
