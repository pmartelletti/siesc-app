<?php

namespace Siesc\PartesBundle\Form;

use Doctrine\ORM\EntityRepository;
use Siesc\AppBundle\Entity\Docente;
use Siesc\PartesBundle\Entity\Novedad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\SecurityContextInterface;

class NovedadType extends AbstractType
{
    protected $security;

    public function __construct(SecurityContextInterface $security)
    {
        $this->security = $security;
    }

    /**
     * @return Docente
     */
    protected function getLoggedUser()
    {
        return $this->security->getToken()->getUser();
    }

        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipo')
        ;
        // si no es RL, mostrar solo los convenios de su funcion
        if (!$this->security->isGranted('ROLE_PARTES_RL')) {
            $builder->add('convenio', 'entity', array(
                'class' => 'Siesc\PartesBundle\Entity\Convenio',
                'empty_value' => '',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->andWhere('c.funcion = :funcion')
                        ->setParameter('funcion', $this->getLoggedUser()->getFuncionPrincipal())
                    ;
                },
                'mapped' => false
            ));
        } else {
            $builder->add('convenio', 'entity', array(
                'class' => 'Siesc\PartesBundle\Entity\Convenio',
                'mapped' => false
            ));
        }

        $builder
            ->add('cargoDocente', null, array(
                'attr' => array('id' => 'cargo-docente')
            )) // we clean in the JS file
            ->add('revista')
            ->add('fechaDesde', null, array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr' => array('class' => 'datepicker-max-today')
            ))
            ->add('fechaHasta', null, array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr' => array('class' => 'datepicker-min-today')
            ))
            ->add('observaciones')
            ->addEventListener(FormEvents::POST_SET_DATA, function(FormEvent $event){
                /** @var Novedad $novedad */
                $novedad = $event->getData();
                if ($novedad->getId()) {
                    $event->getForm()->get('convenio')->setData($novedad->getCargoDocente()->getConvenio());
                }
            })
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Siesc\PartesBundle\Entity\Novedad'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'siesc_partes_novedad_form';
    }
}
