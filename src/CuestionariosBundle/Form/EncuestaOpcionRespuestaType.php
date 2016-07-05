<?php

namespace CuestionariosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EncuestaOpcionRespuestaType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('textoOpcion')
                ->add('encuestaPregunta')
                ->add('orden')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'CuestionariosBundle\Entity\EncuestaOpcionRespuesta'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'cuestionariosbundle_encuestaopcionrespuesta';
    }

}
