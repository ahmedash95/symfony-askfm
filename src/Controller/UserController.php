<?php

namespace App\Controller;

use App\Repository\QuestionRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends SiteController
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
     * @Route("/questions", name="user_questions")
     *
     * @param QuestionRepository $questionRepo
     *
     * @return Response
     */
    public function questionsPage(QuestionRepository $questionRepo) : Response
    {
        $user = $this->getUser();

        $questions = $questionRepo->findNotAnsweredQuestions([
            'user_id' => $user->getId(),
        ]);

        return $this->render('site/user/questions.html.twig', [
            'user'      => $user,
            'questions' => $questions,
        ]);
    }
}
