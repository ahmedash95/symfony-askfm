<?php

namespace App\Controller;

use App\Entity\Question;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends SiteController
{
	/**
	 * @var UserRepository
	 */
	private $userRepo;

	public function __construct(UserRepository $userRepo)
	{
		$this->userRepo = $userRepo;
	}

	/**
     * @Route("/u/{username}", name="user_profile")
     */
    public function index($username)
    {
		$user = $this->userRepo->findOneBy(['username' => $username]);
		if(!$user){
			throw new NotFoundHttpException('user not found');
		}

		return $this->render('site/user/profile.html.twig',[
			'user' => $user
		]);
    }

	/**
	 * @Route("/u/{username}/ask", name="profile_question")
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function askQuestionSubmit(Request $request,$username){
		$this->validateToken($request,'profile_question');
		$user = $this->userRepo->findOneBy(['username' => $username]);
		if(!$user){
			throw new NotFoundHttpException('user not found');
		}

		$question = new Question();
		$question->setQuestion($request->request->get('question'));
		$question->setQuestionBy($this->getUser()->getId());
		$question->setUserId($user->getId());
		$question->setIsAnonymous($request->request->getBoolean('anonymous',true));
		$question->setCreatedAt(new DateTime());

		$this->entityManagerPersist($question);

		$this->addFlash('success','Your question has been sent');

		return $this->redirectToRoute('user_profile',['username' => $user->getUsername()]);
	}
}
