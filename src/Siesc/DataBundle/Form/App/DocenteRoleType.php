<?php

namespace Siesc\DataBundle\Form\App;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocenteRoleType extends AbstractType
{
    private $choices = array(
        'ROLE_PARTES_SECRETARIO' => 'Secretario',
        'ROLE_PARTES_LIQUIDADOR' => 'Liquidador',
        'ROLE_PARTES_ADMIN' => 'Administrador',
        'ROLE_PARTES_RL' => 'Representante Legal'
    );

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
            $roles = $event->getData()->getRoles();
            $defaultRole = '';
            foreach($roles as $role) {
                if (array_key_exists($role, $this->choices)) {
                    $defaultRole = $role;
                    break;
                }
            }

            $form = $event->getForm();
            $form
                ->add('role', 'choice', array(
                    'label' => 'Rol del usuario',
                    'empty_value' => 'Elija un rol',
                    'data' => $defaultRole,
                    'choices' => $this->choices,
                    'mapped' => false
                ))
            ;
        });
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'siesc_databundle_app_docente_role';
    }
} 