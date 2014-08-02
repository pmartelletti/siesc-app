<?php

namespace Siesc\PartesBundle\EventListener;


use Siesc\PartesBundle\Security\ActionNotAllowedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\Routing\RouterInterface;

class ActionNotAllowedListener
{
    private $router;
    private $session;

    public function __construct(RouterInterface $router, SessionInterface $session)
    {
        $this->router = $router;
        $this->session = $session;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getException();
        if ($exception instanceof ActionNotAllowedException) {
            // we set some flash messages
            $this->session->getBag('flashes')->add('danger', $exception->getMessage());
            // we redirect to the page
            $response = new RedirectResponse($this->router->generate($exception->getRedirectUrl()));
            $event->setResponse($response);
        }
    }
} 