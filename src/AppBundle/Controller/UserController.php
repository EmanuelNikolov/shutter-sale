<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends Controller
{

    /**
     * Registers a user.
     * @Route("/register", name="user_register", methods={"GET", "POST"})
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $userPasswordEncoder
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(
      Request $request,
      UserPasswordEncoderInterface $userPasswordEncoder
    ) {
        if ($this->container->get('security.authorization_checker')
          ->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('user_show', [
              'id' => $this->getUser()->getId(),
            ]);
        }

        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $encodedPassword = $userPasswordEncoder->encodePassword($user,
              $user->getPlainPassword());
            $user->setPassword($encodedPassword);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('security_login');
        }

        return $this->render('user/register.html.twig', [
          'form' => $form->createView()
        ]);
    }

    /**
     * Displays a form to edit an existing user entity.
     * @Route("/user/edit", name="user_edit", methods={"GET", "POST"})
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_show',
              ['id' => $user->getId()]);
        }

        return $this->render('user/edit.html.twig', [
          'user' => $user,
          'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a User entity.
     * @Route(
     *     "/user/{id}",
     *     name="user_show",
     *     methods={"GET"},
     *     requirements={"id" = "\d+"}
     * )
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(User $user)
    {
        return $this->render('user/show.html.twig', [
          'user' => $user,
        ]);
    }
}
