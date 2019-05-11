<?php

namespace App\Controller;

use App\Entity\User;
use App\Messages\UserRegister;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegisterController extends SiteController
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;
    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, ValidatorInterface $validator)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->validator = $validator;
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request)
    {
        if ($request->isMethod(self::METHOD_POST)) {
            return $this->doRegister($request);
        }

        return $this->render('site/auth/register.html.twig', [
            'errors' => [],
        ]);
    }

    private function doRegister(Request $request)
    {
        $this->validateToken($request, 'app_register');

        $user = new User();
        $user->setEmail($request->request->get('email'));
        $user->setUsername($request->request->get('username'));
        $user->setPassword($this->passwordEncoder->encodePassword($user, $request->request->get('password')));
        $user->generateToken();

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            return $this->render('site/auth/register.html.twig', [
                'errors' => $errors,
            ]);
        }

        $this->entityManagerFlush($user);

        $this->dispatchMessage(new UserRegister($user));

        return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("register/verify/{token}", name="app_register_verify")
     *
     * @param Request $request
     * @param $token
     * @param UserRepository $userRepo
     *
     * @return Response
     */
    public function verifyUser(Request $request, $token, UserRepository $userRepo): Response
    {
        /**
         * @var User
         */
        $user = $userRepo->findOneBy(['last_token' => $token]);
        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }
        $user->setVerified(true);
        $user->generateToken();

        $this->entityManagerFlush($user);

        $this->addFlash('success', 'Your account has been activated!');

        return new RedirectResponse('/');
    }
}
