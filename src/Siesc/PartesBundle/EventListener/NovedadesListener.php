<?php

namespace Siesc\PartesBundle\EventListener;


use FOS\UserBundle\Model\UserInterface;
use Siesc\PartesBundle\Entity\Novedad;
use Siesc\PartesBundle\NovedadTransitions;
use SM\Factory\Factory;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Security\Core\SecurityContext;

class NovedadesListener
{
    private $transitionsFactory;
    private $security;

    public function __construct(Factory $stateFactory, SecurityContext $security)
    {
        $this->transitionsFactory = $stateFactory;
        $this->security = $security;
    }

    /**
     * @return UserInterface
     */
    public function getLoggedUser()
    {
        return $this->security->getToken()->getUser();
    }

    public function onCreate(GenericEvent $event)
    {
        /** @var Novedad $novedad */
        $novedad = $event->getSubject();
        $novedad->setSecretario($this->getLoggedUser());
        $transitions = $this->transitionsFactory->get($novedad, NovedadTransitions::GRAPH);
        if ($transitions->can(NovedadTransitions::SIESC_CREAR)) {
            $transitions->apply(NovedadTransitions::SIESC_CREAR);
        }
    }

    public function postEdit(GenericEvent $event)
    {
        $novedad = $event->getSubject();
        $transitions = $this->transitionsFactory->get($novedad, NovedadTransitions::GRAPH);
        if ($transitions->can(NovedadTransitions::SIESC_ENVIAR_CAMBIOS)) {
            $transitions->apply(NovedadTransitions::SIESC_ENVIAR_CAMBIOS);
        }

    }
} 