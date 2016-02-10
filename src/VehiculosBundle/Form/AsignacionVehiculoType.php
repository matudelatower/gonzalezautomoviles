<?php

namespace VehiculosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AsignacionVehiculoType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                
//               
                 ->add('cliente', 'jqueryautocomplete', array(
                    'class' => 'ClientesBundle:Cliente',
//					'choice_label'      => 'nombreCompleto',
                    'search_method' => 'getClienteByDni',
                    'required' => false,
                    'route_name' => 'get_cliente_by_dni',
                     'attr'=>array('placeholder'=>'Ingrese DNI o CUIT')
//					'route_name'    => "buscarPersonaConDominio",
//					'class'         => 'PersonaBundle:Persona',
//					'property'      => 'nombreCompleto',
//					'search_method' => 'getEmpadronadoresPorSector',
                  
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
        return 'vehiculosbundle_asignacion_vehiculo';
    }

}
