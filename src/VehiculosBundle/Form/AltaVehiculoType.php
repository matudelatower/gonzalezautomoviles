<?php

namespace VehiculosBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AltaVehiculoType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    private $bandera;

    function __construct($bandera=false)
    {
        $this->bandera = $bandera;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('documento', 'text', array(
                'attr' => array('class' => 'maskdocumento')
            ))
            ->add('fechaEmisionDocumento', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => array(
                    'class' => 'datepicker',
                ),
            ))
            ->add('vin', 'text', array(
                'attr' => array('class' => 'maskVin')
            ))
            ->add('chasis', 'text', array(
                'attr' => array('readonly' => 'readonly')
            ));

        if ($this->bandera == 'edit') {
            $builder->add('modelo', 'entity', array(
                    'class' => 'VehiculosBundle:CodigoModelo',
                    'attr' => array(
                        'class' => 'select2'
                    ),
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('cm')
                            ->orderBy('cm.nombreModelo', 'ASC');
                    },
                )
            );
        } else {
            $builder->add('modelo', 'entity', array(
                    'class' => 'VehiculosBundle:CodigoModelo',
                    'attr' => array(
                        'class' => 'select2'
                    ),
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('cm')
                            ->where('cm.activo = true')
                            ->orderBy('cm.nombreModelo', 'ASC');
                    },
                )
            );
        }


        $builder->add('colorVehiculo', 'entity', array(
                'class' => 'VehiculosBundle:ColorVehiculo',
                'attr' => array(
                    'class' => 'select2'
                ),
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('cm')
                        ->where('cm.activo = true')
                        ->orderBy('cm.color', 'ASC');
                },
            )
        )
            ->add('motor')
            ->add('importe', 'money', array(
                'attr' => array('class' => 'maskmoney')
            ))
            ->add('impuestos', 'money', array(
                'attr' => array('class' => 'maskmoney')
            ))
            ->add('numeroPedido')
            ->add('tipoVentaEspecial', 'entity', array(
                'class' => 'VehiculosBundle:TipoVentaEspecial',
                'label' => 'Tipo venta',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
            ))
            ->add('numeroGrupo', 'text', array(
                'label_attr' => array('class' => 'hidden plan-field'),
                'attr' => array('class' => 'hidden plan-field')
            ))
            ->add('numeroOrden', 'text', array(
                'label_attr' => array('class' => 'hidden plan-field'),
                'attr' => array('class' => 'hidden plan-field')
            ))
            ->add('numeroSolicitud', 'text', array(
                'label_attr' => array('class' => 'hidden plan-field'),
                'attr' => array('class' => 'hidden plan-field')
            ))
            ->add('cliente', 'jqueryautocomplete', array(
                'label' => 'Cliente',
                'class' => 'ClientesBundle:Cliente',
                'search_method' => 'getClienteByApellido',
                'required' => false,
                'route_name' => 'get_cliente_by_apellido',
                'label_attr' => array('class' => 'hidden cliente'),
                'attr' => array('class' => 'hidden cliente'),
                'query_builder' => function (EntityRepository $er) {
	                return $er->createQueryBuilder('c')
	                          ->setMaxResults(1);
                },
            ))
            ->add('remito', new RemitoType());
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VehiculosBundle\Entity\Vehiculo'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'vehiculosbundle_alta_vehiculo';
    }

}
