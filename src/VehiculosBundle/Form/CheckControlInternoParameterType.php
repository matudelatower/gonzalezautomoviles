<?php

namespace VehiculosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CheckControlInternoParameterType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $data = $options["data"]->get();
        $arrayOptions = array();
        foreach ($data as $k => $value) {
            $arrayOptions = array(
                "label" => $value["label"],
                "required" => $value["required"],
                "attr" => $value["attr"],
            );
            if ($value["type"] == 'choice') {

                $aChoices = array();
                foreach ($value['choices'] as $key => $choice) {
                    $aChoices[$key] = $choice;
                }

                $arrayOptions['choices'] = $aChoices;

                $arrayOptions['expanded'] = $value['expanded'];
                $arrayOptions['multiple'] = $value['multiple'];
            } 
//            elseif ($value["type"] == 'jqueryautocomplete') {
//                $arrayOptions['class'] = $value['class'];
//                $arrayOptions['property'] = $value['property'];
//                $arrayOptions['search_method'] = 'getByLike';
//                $arrayOptions['mapped'] = false;
//            } elseif ($value["type"] == 'date') {
//                $arrayOptions['widget'] = $value['widget'];
//                $arrayOptions['input'] = $value['input'];
//                $arrayOptions['format'] = $value['format'];
//                $arrayOptions['attr'] = array('class' => 'date');
////                $arrayOptions['data'] = new \DateTime();
//            }
            if ($value['value']) {
                if ($value['value'] instanceof \DateTime) {
//                    $arrayOptions['data'] = new \DateTime();
                    $arrayOptions['data'] = $value['value'];
                    unset($arrayOptions['input']);
                } else {
                    $arrayOptions['data'] = $value['value'];
//					if ( $value['type'] == 'checkbox' ) {
//						$arrayOptions['data'] = true;
//					}
                }
            }


            $builder->add($k, $value["type"], $arrayOptions);
//            $builder->add(
//                $k,
//                'checkbox',
//                array(
//                    'data' => false,
//                    'label' => $value["label"],
//                    'required' => false,
//                )
//            );
        }
    }

    public
            function configureOptions(
    OptionsResolver $resolver
    ) {
        $resolver->setDefaults(
                array(
                    'data_class' => 'VehiculosBundle\Form\CheckControlInternoParameter',
                    'csrf_protection' => false,
                )
        );
    }

    public
            function getName() {
        return 'vehiculos_bundle_check_control_interno_parameter_type';
    }

}
