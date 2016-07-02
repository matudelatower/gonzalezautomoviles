<?php

namespace VehiculosBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
//use VehiculosBundle\Form\EventListener\AddAnioCodigoVersionFieldSubscriber;
use Doctrine\ORM\EntityRepository;

class ReporteVehiculosDaniosInternosFilterType extends AbstractType {


	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			
			->add( 'rango',
				'text',
				array(
					'required' => false,
					'label'    => 'Fecha de registro',
					'attr'     => array( 'class' => 'daterange' )
				) );
	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'csrf_protection' => false
		) );
	}

	/**
	 * @return string
	 */
	public function getName() {
		return 'vehiculosbundle_reporte_vehiculos_danios_internos_filter';
	}

}
