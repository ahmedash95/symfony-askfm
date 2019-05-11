<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends SiteController
{
    /**
     * @Route("/login", name="app_login")
     *
     * @param Request             $request
     * @param UserRepository      $user
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return Response
     */
    public function login(Request $request, UserRepository $user, AuthenticationUtils $authenticationUtils) : Response
    {
        if ($request->isMethod(self::METHOD_POST)) {
            $this->validateToken($request, 'app_login');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('site/auth/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('Will be intercepted before getting here');
    }
}
