<?php

namespace AppBundle\Controller;

use AppBundle\Form\ChangePasswordType;
use AppBundle\Form\LoginType;
use AppBundle\Form\Model\ChangePassword;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request as Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{

    /**
     * Login a User.
     * @Route("/login", name="security_login", methods={"GET", "POST"})
     *
     * @param \Symfony\Component\Security\Http\Authentication\AuthenticationUtils $authenticationUtils
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
        if ($this->container->get('security.authorization_checker')
          ->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('user_show', [
              'id' => $this->getUser()->getId(),
            ]);
        }

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
     * @Route("/logout", name="security_logout", methods={"GET"})
     */
    public function logoutAction()
    {
    }

    /**
     * Changes the logged in user password.
     *
     * @Route(
     *     "/user/edit/password",
     *     name="security_change_password",
     *     methods={"GET", "POST"}
     * )
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $userPasswordEncoder
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function changePasswordAction(
      Request $request,
      UserPasswordEncoderInterface $userPasswordEncoder
    ) {
        $changePasswordModel = new ChangePassword();

        $form = $this->createForm(
          ChangePasswordType::class,
          $changePasswordModel
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();

            $encodedPassword = $userPasswordEncoder->encodePassword($user,
              $changePasswordModel->getNewPassword());
            unset($changePasswordModel);
            $user->setPassword($encodedPassword);

            $this->getDoctrine()->getManager()->flush();

            // Weird way to force logout a user. But hey, it works
            $session = $this->get('session');
            $session = new Session();
            $session->invalidate();

            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/change_password.html.twig', [
          'form' => $form->createView(),
        ]);
    }
}
