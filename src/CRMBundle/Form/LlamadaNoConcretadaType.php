<?php

namespace CRMBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LlamadaNoConcretadaType extends AbstractType {
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {

		$aEncuestasRealizadas = $options['encuestas_realizadas'];
		$builder
			->add('encuesta')
//			->add( 'encuesta',
//				'entity',
//				array(
//					'class'         => 'CRMBundle\Entity\Encuesta',
//					'choice_label'  => 'nombre',
//					'query_builder' => function ( EntityRepository $er ) use ( $aEncuestasRealizadas ) {
//
//						return $er->createQueryBuilder( 'e' )
//						          ->where( 'e.activo = true' )
//						          ->andWhere( 'e.id not in (:encuestas)' )
//						          ->setParameter( 'encuestas', $aEncuestasRealizadas );
//					}
//				) )
			->add( 'motivo' )
			->add( 'cancelarEncuesta',
				'checkbox',
				array(
					'label'    => 'Cancelar encuesta?',
					'mapped'   => false,
					'required' => false
				) );
	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'data_class'           => 'CRMBundle\Entity\LlamadaNoConcretada',
			'encuestas_realizadas' => array()
		) );
	}

	/**
	 * @return string
	 */
	public function getName() {
		return 'crmbundle_llamadanoconcretada';
	}
}
