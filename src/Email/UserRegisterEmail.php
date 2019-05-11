<?php

namespace App\Email;

use App\Entity\User;

class UserRegisterEmail extends Email
{
    public $subject = 'Welcome to Askfm.com';

    public $template = 'emails/user/register_verification.html.twig';

    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->receiver = $user->getEmail();
    }

    public function getData(): array
    {
        return [
            'username'    => $this->user->getUsername(),
            'verify_path' => ['app_register_verify', ['token' => $this->user->getLastToken()]],
        ];
    }
}
