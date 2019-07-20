<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class HomeController extends SiteController
{
    /**
     * @Route("/home", name="app_homepage")
     * @Route("/", name="app_home")
     */
    public function index()
    {
        return $this->render('site/home.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
