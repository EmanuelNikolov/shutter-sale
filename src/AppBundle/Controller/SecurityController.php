<?php

namespace AppBundle\Controller;

use AppBundle\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{

    /**
     * Login a User.
     * @Route("/login", name="security_login")
     * @param \Symfony\Component\Security\Http\Authentication\AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginType::class, [
          '_username' => $lastUsername,
        ]);

        return $this->render('security/login.html.twig', [
          'form' => $form->createView(),
          'last_username' => $lastUsername,
          'error' => $error,
        ]);
    }

    /**
     * Logout a User.
     * @Route("/logout", name="security_logout")
     */
    public function logoutAction()
    {
    }
}
