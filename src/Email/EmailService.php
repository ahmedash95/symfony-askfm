<?php

namespace App\Email;

use Exception;
use Swift_Mailer;
use Twig\Environment;

class EmailService
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $templating;

    /**
     * EmailService constructor.
     *
     * @param Swift_Mailer $mailer
     */
    public function __construct(Swift_Mailer $mailer, Environment $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    /**
     * @param IEmail $email
     *
     * @throws Exception
     *
     * @return int The number of successful recipients. Can be 0 which indicates failure
     */
    public function send(IEmail $email) : int
    {
        $message = (new \Swift_Message($email->getSubject()))
            ->setFrom($email->getFrom())
            ->setTo($email->getEmailTo())
            ->setBody(
                $this->templating->render(
                    $email->getTemplate(),
                    $email->getData()
                ),
                'text/html'
            );

        return $this->mailer->send($message);
    }
}
