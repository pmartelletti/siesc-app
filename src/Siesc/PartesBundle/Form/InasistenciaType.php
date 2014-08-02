<?php

namespace Siesc\PartesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InasistenciaType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('horas', null, array(
                'horizontal_input_wrapper_class' => 'col-lg-12'
            ))
            ->add('cargo', 'entity', array(
                'class' => 'SiescPartesBundle:CargoDocente',
                'horizontal_input_wrapper_class' => 'col-lg-12'
            ))
            ->add('motivo', 'entity', array(
                'class' => 'SiescPartesBundle:MotivoInasistencia',
                'horizontal_input_wrapper_class' => 'col-lg-12'
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Siesc\PartesBundle\Entity\Inasistencia'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'siesc_partesbundle_inasistencia';
    }
}
