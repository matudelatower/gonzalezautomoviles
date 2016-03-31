<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemAplicativoType extends AbstractType
{

    private $appManager;

    public function __construct($appManager)
    {
        $this->appManager = $appManager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $rutas = $this->appManager->getARoutes();
        $controllers = $this->appManager->getControllers();

        $builder
            ->add('nombre')
            ->add(
                'ruta',
                'choice',
                array(
                    'choices' => $rutas,
                    'attr' => array(
                        'class' => 'select2'
                    )
                )
            )
            ->add(
                'aplicativo'

            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\ItemAplicativo'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_itemaplicativo';
    }
}
