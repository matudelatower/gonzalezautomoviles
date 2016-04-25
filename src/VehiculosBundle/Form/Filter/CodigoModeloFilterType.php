<?php

namespace VehiculosBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CodigoModeloFilterType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('anio', 'text', array(
                    'required' => false
                ))
                ->add('codigo', 'text', array(
                    'required' => false
                ))
                ->add('version', 'text', array(
                    'required' => false
                ));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'csrf_protection' => false
        ));
    }

    public function getName() {
        return 'vehiculos_bundle_codigo_modelo_filter_type';
    }

}
