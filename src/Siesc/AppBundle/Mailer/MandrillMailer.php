<?php

namespace Siesc\AppBundle\Mailer;

use Hip\MandrillBundle\Dispatcher;
use Hip\MandrillBundle\Message;

class MandrillMailer
{
    private $mailer;
    private $options;

    public function __construct(Dispatcher $mailer, array $options = array())
    {
        $this->mailer = $mailer;
        $this->options = $options;
    }

    public function sendEmail(Message $message, $template, array $template_content = array())
    {
        return $this->mailer->send($message, $template, $template_content);
    }

    public function createMessage()
    {
        return new Message();
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

} 