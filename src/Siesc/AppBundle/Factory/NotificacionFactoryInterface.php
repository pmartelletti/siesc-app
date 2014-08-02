<?php

namespace Siesc\AppBundle\Factory;


use SM\Event\TransitionEvent;

interface NotificacionFactoryInterface
{
    public function createFromTransition(TransitionEvent $event, $object);
} 