<?php

namespace Siesc\PartesBundle\Security;


use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ActionNotAllowedException extends AccessDeniedHttpException
{
    private $redirectUrl;

    public function __construct($redirectUrl, $message = null, \Exception $previous = null, $code = 0)
    {
        parent::__construct('El usuario NO tiene permiso para realizar la operacion requrida.', $previous, $code);
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * @return mixed
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }
} 