<?php

namespace Siesc\DataBundle\Form\App;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DocenteImportType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', 'file', array(
                'required' => true,
                'label' => 'Archivo CSV'
            ))
        ;

    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'siesc_databundle_app_docente_import';
    }
} 