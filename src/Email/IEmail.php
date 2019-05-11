<?php

namespace App\Email;

interface IEmail
{
    /**
     * Variables to share with template.
     *
     * @return array
     */
    public function getData(): array;

    /**
     * Email receiver.
     *
     * @return string
     */
    public function getEmailTo(): string;

    /**
     * Email content.
     *
     * @return string
     */
    public function getTemplate(): string;

    /**
     * Email sender.
     *
     * @return string
     */
    public function getFrom(): string;

    /**
     * Email Subject.
     *
     * @return string
     */
    public function getSubject(): string;
}
