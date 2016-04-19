<?php

namespace ClientesBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

//use VehiculosBundle\Form\EventListener\AddAnioCodigoVersionFieldSubscriber;

class ClientesFilterType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('apellido', 'text', array(
                    'required' => false
                ))
                ->add('reventa', 'choice', array(
                    'empty_value' => 'Seleccione',
                    'choices' => array(
                        'true' => 'SI',
                        'false' => 'NO',
                    ),
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false,
                ))
                ->add('numeroDocumento', 'text', array(
                    'required' => false
                ));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'csrf_protection' => false
        ));
    }

    public function getName() {
        return 'clientes_bundle_clientes_filter_type';
    }

}
