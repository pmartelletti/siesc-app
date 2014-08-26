<?php

namespace Siesc\AppBundle\Mailer;


use FOS\UserBundle\Model\UserManager;
use Hip\MandrillBundle\Message;
use Siesc\AppBundle\Entity\Docente;
use Symfony\Component\Routing\RouterInterface;

class DocenteMailer
{
    const TEMPLATE = 'notificaciones-internas';
    private $mailer;
    private $router;

    public function __construct(MandrillMailer $mailer, RouterInterface $router)
    {
        $this->mailer = $mailer;
        $this->router = $router;
    }

    public function sendCredentialsEmail(Docente $docente, $tempPassword)
    {
        //$toEmail = $notificacion->getDestinatario()->getEmail();
        $toEmail = $docente->getEmail();
        //$toEmail = 'pmartelletti@gmail.com';
        if (!empty($toEmail)) {
            $message = $this->mailer->createMessage();
            $message
                ->addTo($toEmail)
                ->setSubject($this->createSubject())
            ;
            $this->createTemplateVars($docente, $message, $tempPassword);

            return $this->mailer->sendEmail($message, self::TEMPLATE);
        }
        return false;
    }

    private function createSubject()
    {
        return sprintf('Ha sido dado de alta en SIESC. Bienvenido!');
    }

    private function createTemplateVars(Docente $docente, Message $message, $password)
    {
        $options = array_merge($this->mailer->getOptions(), array(
            'subject' => $this->createSubject(),
            'notificacion' => sprintf('Estimado %s: <br><br> %s <br><br> %s',
                $docente->getFullName(),
                'Su institucion lo ha dado de alta en el sistema SIESC. Para utilizar el sistema, ingrese con su email y
                la siguiente contrasena temporal: <br><br> <strong>' . $password . '</strong><br><br>
                Por favor recuerde modificarla ni bien ingrese al sistema por una que recuerde con mas facilida.',
                $this->getUrlMessage()
            )
        ));

        foreach($options as $key => $value) {
            $message->addGlobalMergeVar($key, $value);
        }
    }

    private function getUrlMessage()
    {
        return sprintf('Para ingresar al sistema, haga click <a href="%s">aca</a>',
            $this->router->generate('fos_user_security_login', array(), true)
        );
    }
} 