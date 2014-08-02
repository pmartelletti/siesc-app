<?php

namespace Siesc\DataBundle\Form\App;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocenteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('apellido')
            ->add('cuil', 'text')
            ->add('email')
            ->add('enabled')
            ->add('direccion')
            ->add('telefono')
            ->add('observaciones')
            ->add('funcionPrincipal');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Siesc\AppBundle\Entity\Docente'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'siesc_databundle_app_docente';
    }

}
