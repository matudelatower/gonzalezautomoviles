<?php

namespace VehiculosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use VehiculosBundle\Form\EventListener\AddTipoDanioInternoFieldSuscriber;
use VehiculosBundle\Form\EventListener\AddCategoriaDanioInternoFieldSubscriber;

class DanioVehiculoInternoType extends AbstractType {
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$factory                         = $builder->getFormFactory();
		$categoriaDanioInternoSubscriber = new AddCategoriaDanioInternoFieldSubscriber( $factory );
		$builder->addEventSubscriber( $categoriaDanioInternoSubscriber );
		$tipoDanioInternoSuscriber = new AddTipoDanioInternoFieldSuscriber( $factory );
		$builder->addEventSubscriber( $tipoDanioInternoSuscriber );


		$builder
//            ->add('numeroOrdenArreglo')
//            ->add('detalle')
//            ->add('solucionado')
//			->add( 'tipoDanioInterno' )
//			->add( 'fotoDanioInterno',
//				'bootstrapcollection',
//				array(
//					'type'         => new FotoDanioInternoType(),
//					'allow_add'    => true,
//					'allow_add'    => true,
//					'by_reference' => true
//				) )
//            ->add('creadoPor')
//            ->add('actualizadoPor')
//            ->add('vehiculo')
		;
	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'data_class' => 'VehiculosBundle\Entity\DanioVehiculoInterno'
		) );
	}

	/**
	 * @return string
	 */
	public function getName() {
		return 'vehiculosbundle_daniovehiculointerno';
	}
}
