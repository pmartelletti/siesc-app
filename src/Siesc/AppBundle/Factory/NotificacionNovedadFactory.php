<?php

namespace Siesc\AppBundle\Factory;


use FOS\UserBundle\Model\UserInterface;
use Siesc\AppBundle\Entity\NotificacionNovedad;
use Siesc\PartesBundle\Entity\Novedad;
use SM\Event\TransitionEvent;
use Symfony\Component\Security\Core\SecurityContextInterface;

class NotificacionNovedadFactory implements NotificacionFactoryInterface
{
    private $security;

    public function __construct(SecurityContextInterface $security)
    {
        $this->security = $security;
    }

    /**
     * @return UserInterface
     */
    public function getLoggedUser()
    {
        return $this->security->getToken()->getUser();
    }

    public function createFromTransition(TransitionEvent $event, $object)
    {
        /** @var Novedad $object */
        $notificacion = $this->createNew();
        $notificacion->setNovedad($object);
        $notificacion->setEncargado($this->getLoggedUser());
        //$notificacion->getDestinatario($object->getSecretario());
        $notificacion->setDestinatario($this->getLoggedUser());
        $notificacion->setFecha(new \DateTime());
        $notificacion->setMensaje(
            sprintf('El usuario %s ha cambiado el estado de la novedad "%s" a %s',
                $this->getLoggedUser(), $object, ucwords(implode(' ', explode('_', $event->getState())))
            )
        );

        return $notificacion;
    }

    public function createNew()
    {
        return new NotificacionNovedad();
    }
} 