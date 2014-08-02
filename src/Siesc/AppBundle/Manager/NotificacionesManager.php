<?php

namespace Siesc\AppBundle\Manager;


use Doctrine\ORM\EntityManager;
use Siesc\AppBundle\Factory\NotificacionFactoryInterface;
use Siesc\AppBundle\Mailer\NotificacionMailer;

class NotificacionesManager
{
    private $em;
    private $mailer;
    private $factory;

    public function __construct(EntityManager $em, NotificacionFactoryInterface $factory, NotificacionMailer $mailer)
    {
        $this->em = $em;
        $this->factory = $factory;
        $this->mailer = $mailer;
    }

    public function createNotification($event, $object)
    {
        $notificacion = $this->factory->createFromTransition($event, $object);
        // save changes to db
        $this->em->persist($notificacion);
        $this->em->flush();

        // probably do something with the email here?
        $this->mailer->sendNotificationMail($notificacion);
    }
} 