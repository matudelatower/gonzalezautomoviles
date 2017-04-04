<?php

namespace CRMBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EncuestaParameterType extends AbstractType {
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$data         = $options["data"]->get();
		$arrayOptions = array();
		foreach ( $data as $k => $value ) {
			$arrayOptions = array(
				"label"    => $value["label"],
				"required" => $value["required"],
				"attr"     => $value["attr"],
			);
			if ( $value["type"] == 'choice' ) {

				$aChoices = array();
				foreach ( $value['choices'] as $key => $choice ) {
					$aChoices[ $key ] = $choice;
				}

				$arrayOptions['choices'] = $aChoices;

				$arrayOptions['expanded'] = $value['expanded'];
				$arrayOptions['multiple'] = $value['multiple'];
			} elseif ( $value["type"] == 'jqueryautocomplete' ) {
				$arrayOptions['class']         = $value['class'];
				$arrayOptions['property']      = $value['property'];
				$arrayOptions['search_method'] = 'getByLike';
				$arrayOptions['mapped']        = false;
			} elseif ( $value["type"] == 'date' ) {
				$arrayOptions['widget'] = $value['widget'];
				$arrayOptions['input']  = $value['input'];
				$arrayOptions['format'] = $value['format'];
				$arrayOptions['attr']   = array( 'class' => 'date' );

			}
			if ( $value['value'] ) {
				if ( $value['value'] instanceof \DateTime ) {

					$arrayOptions['data'] = $value['value'];
					unset( $arrayOptions['input'] );
				} else {
					$arrayOptions['data'] = $value['value'];

				}
			}


			$builder->add( $k, $value["type"], $arrayOptions );

		}
	}

	public function configureOptions(
		OptionsResolver $resolver
	) {
		$resolver->setDefaults(
			array(
				'data_class'      => 'CRMBundle\Form\Model\EncuestaParameter',
				'csrf_protection' => false,
			)
		);
	}

	public
	function getName() {
		return 'crm_bundle_encuesta_parameter_type';
	}
}
