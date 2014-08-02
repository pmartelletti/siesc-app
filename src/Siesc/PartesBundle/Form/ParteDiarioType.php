<?php

namespace Siesc\PartesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ParteDiarioType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha', null, array('widget' => 'single_text', 'attr' => array('class' => 'datepicker')))
            ->add('observaciones', null, array('required' => false ))
            ->add('inasistencias', 'collection', array(
                'type' => new InasistenciaType(),
                'allow_add' => true,
                'by_reference' => false,
                'widget_add_btn' => array('label' => "Agregar"),
                'options' => array('label_render' => false)
            ))
            ->add('horasExtras', 'collection', array(
                'type' => new HorasExtraType(),
                'allow_add' => true,
                'by_reference' => false,
                'options' => array('label_render' => false)
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Siesc\PartesBundle\Entity\ParteDiario'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'siesc_partesbundle_partediario';
    }
}
