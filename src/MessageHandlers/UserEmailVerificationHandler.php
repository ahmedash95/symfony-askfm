<?php


namespace App\MessageHandlers;

use App\Email\EmailService;
use App\Email\UserRegisterEmail;
use App\Messages\UserRegister;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UserEmailVerificationHandler implements MessageHandlerInterface
{
	/**
	 * @var EmailService
	 */
	private $emailService;

	public function __construct(EmailService $emailService)
	{
		$this->emailService = $emailService;
	}

	public function __invoke(UserRegister $userRegister)
	{
		$email = new UserRegisterEmail($userRegister->getUser());
		$this->emailService->send($email);
	}
}