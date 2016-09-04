<?php

namespace VehiculosBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ReporteVehiculosAsignadosAClienteFilterType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('cliente', 'jqueryautocomplete', array(
                    'class' => 'ClientesBundle:Cliente',
                    'search_method' => 'getClienteByApellido',
                    'required' => false,
                    'route_name' => 'get_cliente_by_apellido',
                    'attr' => array('placeholder' => 'Ingrese Apellido'),
                ))
                ->add('facturado', 'choice', array(
                    'required' => false,
                    'choices' => array(
                        1 => 'SI',
                        2 => 'NO',
                    )
                ))
                ->add('patentado', 'choice', array(
                    'required' => false,
                    'choices' => array(
                        1 => 'SI',
                        2 => 'NO',
                    )
                ))
                ->add('dias', 'text', array(
                    'required' => false,
                    'attr' => array(
                        'class' => 'slider',
                        'data-slider-min' => "0",
                        'data-slider-max' => "1200",
                        'data-slider-step' => "1",
                        'data-slider-value' => "[0,0]",
                        'data-slider-orientation' => "horizontal",
                        'data-slider-selection' => "before",
                        'data-slider-tooltip' => "show",
                        'data-slider-id' => "blue"
                    )
                ));
        $builder->addEventListener(FormEvents::SUBMIT, function ( FormEvent $event ) {
            $data = $event->getData();
            $form = $event->getForm();

            // check if the Product object is "new"
            // If no data is passed to the form, the data is "null".
            // This should be considered a new "Product"
            if ($data['dias']) {
                $form->add('dias', 'text', array(
                    'required' => false,
                    'attr' => array(
                        'class' => 'slider',
                        'data-slider-min' => "0",
                        'data-slider-max' => "1200",
                        'data-slider-step' => "1",
                        'data-slider-value' => "[" . $data['dias'] . "]",
                        'data-slider-orientation' => "horizontal",
                        'data-slider-selection' => "before",
                        'data-slider-tooltip' => "show",
                        'data-slider-id' => "blue"
                    )
                ));
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'csrf_protection' => false
        ));
    }

    public function getName() {
        return 'vehiculos_bundle_reporte_vehiculos_asignados_acliente_filter_type';
    }

}
