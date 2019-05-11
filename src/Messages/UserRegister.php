<?php


namespace App\Messages;

use App\Entity\User;

class UserRegister
{

	/**
	 * @var User $user
	 */
	private $user;

	/**
	 * UserRegister constructor.
	 * @param User $user
	 */
	public function __construct(User $user)
	{
		$this->user = $user;
	}

	/**
	 * @return User
	 */
	public function getUser(){
		return $this->user;
	}
}