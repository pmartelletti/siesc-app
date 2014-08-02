<?php
namespace Siesc\AppBundle\Mailer;


use Hip\MandrillBundle\Dispatcher;
use Hip\MandrillBundle\Message;
use Siesc\AppBundle\Entity\Notificacion;
use Symfony\Component\Routing\RouterInterface;

class NotificacionMailer
{
    const TEMPLATE = 'notificaciones-internas';
    private $mailer;
    private $router;

    public function __construct(MandrillMailer $mailer, RouterInterface $router)
    {
        $this->mailer = $mailer;
        $this->router = $router;
    }

    public function sendNotificationMail(Notificacion $notificacion)
    {
        $toEmail = $notificacion->getDestinatario()->getEmail();
        if (!empty($toEmail)) {
            $message = $this->mailer->createMessage();
            $message
                ->addTo($toEmail)
                ->setSubject($this->createSubject())
            ;
            $this->createTemplateVars($notificacion, $message);

            return $this->mailer->sendEmail($message, self::TEMPLATE);
        }
        return false;
    }

    private function createSubject()
    {
        return sprintf('Ha recibido una nueva notificacion.');
    }

    private function createTemplateVars(Notificacion $notificacion, Message $message)
    {
        $options = array_merge($this->mailer->getOptions(), array(
            'subject' => $this->createSubject(),
            'notificacion' => sprintf('Estimado %s: <br><br> %s. <br><br> %s',
                $notificacion->getDestinatario(), $notificacion->getMensaje(), $this->getUrlMessage($notificacion)
            )
        ));

        foreach($options as $key => $value) {
            $message->addGlobalMergeVar($key, $value);
        }
    }

    private function getUrlMessage(Notificacion $notificacion)
    {
        return sprintf('Para obtener mas detalles, haga click <a href="%s">aca</a>',
            $this->router->generate('app_read_notificacion', array('id' => $notificacion->getId()), true)
        );
    }
} 