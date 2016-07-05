<?php

namespace CuestionariosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EncuestaPreguntaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pregunta')
            ->add('estado')
            ->add('orden')           
            ->add('encuestaTipoPregunta')
            ->add('encuesta')            
            ->add('cssClass')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CuestionariosBundle\Entity\EncuestaPregunta'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cuestionariosbundle_encuestapregunta';
    }
}
