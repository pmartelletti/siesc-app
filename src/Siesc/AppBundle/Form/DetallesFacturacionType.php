<?php

namespace Siesc\AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DetallesFacturacionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('razonSocial')
            ->add('cuit')
            ->add('domicilio', new DireccionType())
            ->add('condicionIva', 'choice', array(
                'choices' => array(
                    'excento' => 'Excento',
                    'inscripto' => 'Resp. Inscripto',
                    'monotributo' => 'Resp. Monotributo',
                    'consumidor' => 'Consumidor Final'
                )
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Siesc\AppBundle\Entity\DetallesFacturacion'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'siesc_appbundle_detalles_facturacion';
    }
}