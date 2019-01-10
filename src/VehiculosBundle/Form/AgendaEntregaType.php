<?php

namespace VehiculosBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgendaEntregaType extends AbstractType {

	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$vehiculo = $options['data']->getVehiculo();
		$builder
			->add( 'fecha',
				'date',
				array(
					'widget' => 'single_text',
					'format' => 'dd/MM/yyyy',
					'attr'   => array(
						'class' => 'datepicker',
					),
				) )
			->add( 'hora',
				'time',
				array(
					'widget' => 'single_text',
					'attr'   => array(
						'class' => 'timepicker'
					)
				) )
			->add( 'descripcion' );

		if ($vehiculo) {
			$builder->add('vehiculo',
				'entity',
				[
					'class' => 'VehiculosBundle:Vehiculo',
					'query_builder' => function (EntityRepository $er) use ($vehiculo) {
						return $er->createQueryBuilder('v')
						          ->where('v = :vehiculo')
						          ->setParameter('vehiculo', $vehiculo)
						          ->setMaxResults(1);
					},
				]);
		} else {
			$builder->add('vehiculo');
		}
	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'data_class' => 'VehiculosBundle\Entity\AgendaEntrega'
		) );
	}

	/**
	 * @return string
	 */
	public function getName() {
		return 'vehiculosbundle_agendaentrega';
	}

}
