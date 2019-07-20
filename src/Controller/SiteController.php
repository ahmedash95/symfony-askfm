<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;

class SiteController extends AbstractController
{
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';

    protected function validateToken(Request $request, $id) : void
    {
        if (!$this->isCsrfTokenValid($id, $request->get('token'))) {
            throw new InvalidCsrfTokenException();
        }
    }

    public function entityManagerPersist($object) : void
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($object);
        $entityManager->flush();
    }

    public function getUser() : ?User {
    	$token = $this->container->get('security.token_storage')->getToken();
    	if($token) {
    		return $token->getUser();
		}
    	return null;
	}
}
