<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    public $error='';
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $utils)
    {
        $error=$utils->getLastAuthenticationError();
        $lastUserName=$utils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'error'=>$error,
            'last_username'=>$lastUserName
        ]);
    }

    /**
     * @Route("/logout",name="logout")
     */
    public function logout()
    {
    }

 }
