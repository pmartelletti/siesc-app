<?php

namespace Siesc\DataBundle\Form\Partes;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CargoDocenteType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('docente')
            ->add('convenio')
            ->add('categoria')
            ->add('horas', null, array(
                'attr' => array('class' => 'spinner-input')
            ))
            ->add('fechaAlta', null, array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr' => array('class' => 'datepicker-max-today')
            ))
            ->add('fechaBaja', null, array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr' => array('class' => 'datepicker-min-today')
            ))
            ->add('colegio')
        
        ;
    }
    
    /**
    * @param OptionsResolverInterface $resolver
    */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Siesc\PartesBundle\Entity\CargoDocente'
        ));
    }

    /**
    * @return string
    */
    public function getName()
    {
        return 'siesc_databundle_partes_cargodocente';
    }
    
}
