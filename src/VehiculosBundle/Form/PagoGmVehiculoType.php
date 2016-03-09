<?php

namespace VehiculosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PagoGmVehiculoType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                
                 ->add('fechaPagoGm', 'date', array(
                    'widget' => 'single_text',
                     'required' => 'required',
                    'format' => 'dd-MM-yyyy',
                     'attr' => array('class' => 'datepicker'),
                ))

        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'VehiculosBundle\Entity\Vehiculo'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'vehiculosbundle_pago_gm_vehiculo';
    }

}
