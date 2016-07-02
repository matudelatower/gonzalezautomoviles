<?php

namespace VehiculosBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
//use VehiculosBundle\Form\EventListener\AddAnioCodigoVersionFieldSubscriber;
use Doctrine\ORM\EntityRepository;

class ReporteVehiculosDaniosGmFilterType extends AbstractType {

	private $em;

	public function __construct( $em ) {
		$this->em = $em;
	}

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
				) )
			->add( 'tipoEstadoDanioGm',
				'entity',
				array(
					'class'         => 'VehiculosBundle:TipoEstadoDanioGm',
					'choice_label'  => 'descripcion',
					'required'      => false,
					'query_builder' => function ( EntityRepository $er ) {

						$slugArray = array( 'registrado', 'reclamado');

						return $er->createQueryBuilder( 'te' )
						          ->where( 'te.slug in (:slugs)' )
						          ->setParameter( 'slugs', array_values($slugArray) )
							;
					}
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
		return 'vehiculosbundle_reporte_vehiculos_danios_gm_filter';
	}

}
