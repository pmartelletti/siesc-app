<?php

namespace Siesc\DataBundle\Form\App;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TenantType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => 'Nombre'
            ))
            ->add('subdomain', null, array(
                'label' => "Subdominio"
            ))
            ->add('contactEmail', null, array(
                'label' => 'Email de contacto'
            ))
            ->add('contactName', null, array(
                'label' => 'Nombre de contacto'
            ))
            ->add('contactPhone', null, [
                'label' => 'Telefono'
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Siesc\AppBundle\Entity\Tenant'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'siesc_appbundle_tenant';
    }
}
