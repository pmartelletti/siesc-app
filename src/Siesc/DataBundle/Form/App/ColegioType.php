<?php

namespace Siesc\DataBundle\Form\App;

use Siesc\AppBundle\Form\DireccionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ColegioType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
        
            ->add('codigo')
        
            ->add('porcentajeAporteEstatal')
        
            ->add('telefono')
        
            ->add('cuit')
        
            ->add('distrito')
        
            ->add('funcion')
        
            ->add('direccion', new DireccionType())
        
        ;
    }
    
    /**
    * @param OptionsResolverInterface $resolver
    */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Siesc\AppBundle\Entity\Colegio'
        ));
    }

    /**
    * @return string
    */
    public function getName()
    {
        return 'siesc_databundle_app_colegio';
    }
    
}