<?php

namespace Siesc\DataBundle\EventListener;


use Siesc\AppBundle\Entity\Docente;
use Symfony\Component\EventDispatcher\GenericEvent;

class DocenteListener
{
    public function onPreCreate(GenericEvent $event)
    {
        /** @var Docente $docente */
        $docente = $event->getSubject();
        // set random password
        $docente->setPassword(uniqid(md5('password')));
    }
} 