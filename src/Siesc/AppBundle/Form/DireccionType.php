<?php

namespace Siesc\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DireccionType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('calle')
            ->add('altura')
            ->add('localidad')
            ->add('codigoPostal')
            ->add('provincia')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Siesc\AppBundle\Entity\Direccion'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'siesc_appbundle_direccion';
    }
}
