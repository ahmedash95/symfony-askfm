<?php

namespace App\Email;

abstract class Email implements IEmail
{
    public $data = [];
    public $receiver;
    public $from = 'no-reply@askfm.com';
    public $subject;
    public $template;

    public function getData(): array
    {
        return $this->data;
    }

    public function getEmailTo(): string
    {
        return $this->receiver;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }
}
