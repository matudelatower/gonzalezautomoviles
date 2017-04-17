<?php

namespace PersonasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UbicacionBundle\Form\EventListener\AddDepartamentoFieldSubscriber;
use UbicacionBundle\Form\EventListener\AddLocalidadFieldSubscriber;
use UbicacionBundle\Form\EventListener\AddPaisFieldSubscriber;
use UbicacionBundle\Form\EventListener\AddProvinciaFieldSubscriber;

class PersonaType extends AbstractType {
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$factory                         = $builder->getFormFactory();
		$builder
			->add( 'nombre' )
			->add( 'apellido' )
			->add( 'tipoDocumento' )
			->add( 'numeroDocumento' )
                        ->add( 'fechaNacimiento',
				'date',
				array(
					'widget' => 'single_text',
					'format' => 'dd-MM-yyyy',
					'attr'   => array(
						'class' => 'datepicker',
					),
//                'required'=>false

				) )
                        ->add( 'estadoCivil' )
			->add( 'telefono' )
                        ->add( 'telefonoLaboral' )
			->add( 'celular' )
			->add( 'mail', 'email', array(
				'required'=>false
			) )
			->add( 'web' )
			
			->add( 'calle' )
			->add( 'numeroCalle' )
			->add( 'barrio' )
                        ;

		$builder->addEventSubscriber(new AddPaisFieldSubscriber($factory));
		$builder->addEventSubscriber(new AddProvinciaFieldSubscriber($factory));
		$builder->addEventSubscriber(new AddDepartamentoFieldSubscriber($factory));
		$builder->addEventSubscriber(new AddLocalidadFieldSubscriber($factory));
                $builder->add( 'observacion' );
                
	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'data_class' => 'PersonasBundle\Entity\Persona'
		) );
	}

	/**
	 * @return string
	 */
	public function getName() {
		return 'personasbundle_persona';
	}
}
