<?php

namespace Siesc\DataBundle\Form\Partes;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoriaType extends AbstractType
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
        
            ->add('requiereHoras')
        
            ->add('topeHoras')
        
            ->add('requiereAsignatura')
        
            ->add('funcion')
        
        ;
    }
    
    /**
    * @param OptionsResolverInterface $resolver
    */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Siesc\PartesBundle\Entity\Categoria'
        ));
    }

    /**
    * @return string
    */
    public function getName()
    {
        return 'siesc_databundle_partes_categoria';
    }
    
}
