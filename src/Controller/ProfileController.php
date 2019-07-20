<?php

namespace App\Controller;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use App\Repository\UserRepository;
use DateTime;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        if (!$user) {
            throw new NotFoundHttpException('user not found');
        }

        return $this->render(
            'site/user/profile.html.twig',
            [
                'user' => $user,
            ]
        );
    }

    /**
     * @Route("/u/{username}/ask", name="profile_question")
     *
     * @param Request $request
     *
     * @throws Exception
     *
     * @return RedirectResponse
     */
    public function askQuestionSubmit(Request $request, $username): RedirectResponse
    {
        $this->validateToken($request, 'profile_question');
        $user = $this->userRepo->findOneBy(['username' => $username]);
        if (!$user) {
            throw new NotFoundHttpException('user not found');
        }

        $question = new Question();
        $question->setQuestion($request->request->get('question'));
        $question->setQuestionBy($this->getUser()->getId());
        $question->setUser($user);
        $question->setIsAnonymous($request->request->getBoolean('anonymous', true));
        $question->setCreatedAt(new DateTime());

        $this->entityManagerPersist($question);

        $this->addFlash('success', 'Your question has been sent');

        return $this->redirectToRoute('user_profile', ['username' => $user->getUsername()]);
    }

    /**
     * @Route("/answer/{questionId}/", name="profile_question_answer", methods={"GET"})
     *
     * @param QuestionRepository $questionRepository
     * @param $questionId
     *
     * @throws Exception
     *
     * @return RedirectResponse
     */
    public function answerQuestion(QuestionRepository $questionRepository, $questionId): Response
    {
        $user = $this->getUser();
        $question = $questionRepository->findOneBy([
            'id'      => $questionId,
            'user_id' => $user->getId(),
        ]);

        if (!$question) {
            throw new NotFoundHttpException('question not found');
        }

        return $this->render('site/questions/answer.html.twig', [
            'question' => $question,
        ]);
    }

    /**
     * @Route("/answer/{questionId}/", name="profile_question_answer_submit", methods={"POST"})
     *
     * @param Request            $request
     * @param QuestionRepository $questionRepository
     * @param $questionId
     *
     * @throws Exception
     *
     * @return RedirectResponse
     */
    public function answerQuestionSubmit(Request $request, QuestionRepository $questionRepository, $questionId): Response
    {
        $user = $this->getUser();
        $question = $questionRepository->findOneBy([
            'id'      => $questionId,
            'user_id' => $user->getId(),
        ]);

        if (!$question) {
            throw new NotFoundHttpException('question not found');
        }

        $question->setAnswer($request->request->get('answer'));
        $this->entityManagerPersist($question);

        return $this->redirectToRoute('user_questions');
    }
}
