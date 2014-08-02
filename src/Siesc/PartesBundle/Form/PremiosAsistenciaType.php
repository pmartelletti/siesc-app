<?php
/**
 * Created by JetBrains PhpStorm.
 * User: pablo
 * Date: 10/30/13
 * Time: 1:08 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Siesc\PartesBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PremiosAsistenciaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('desde', 'date', array(
                'widget' => 'single_text',
                'attr' => array('class' => 'datepicker'),
                'label' => 'Inicio Periodo'
            ))
            ->add('hasta', 'date', array(
                'widget' => 'single_text',
                'attr' => array('class' => 'datepicker'),
                'label' => 'Fin Periodo'
            ))
            ->add('seccion', 'entity', array(
                'class' => 'SiescAppBundle:Seccion'
            ))
            ->add('calculate', 'submit', array(
                'label' => 'Calcular Premios'
            ))
        ;

    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'siesc_partesbundle_premiosasistencia';
    }
}