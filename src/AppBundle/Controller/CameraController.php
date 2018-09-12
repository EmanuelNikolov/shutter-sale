<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Camera;
use AppBundle\Form\CameraType;
use AppBundle\Security\CameraVoter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Camera controller.
 *
 * @Route("/")
 */
class CameraController extends Controller
{

    /**
     * Lists all camera entities.
     * @Route("/", name="camera_index", methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cameras = $em->getRepository(Camera::class)->findAll();

        return $this->render('camera/index.html.twig', [
          'cameras' => $cameras,
        ]);
    }

    /**
     * Creates a new Camera entity.
     * @Route("/camera/new", name="camera_new", methods={"GET", "POST"})
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $user = $this->getUser();

        if (true === $user->isRestricted()) {
            throw new AccessDeniedHttpException("Your permissions to post have been restricted.");
        }

        $camera = new Camera();
        $form = $this->createForm(CameraType::class, $camera);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $camera->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($camera);
            $em->flush();

            return $this->redirectToRoute('camera_show',
              ['id' => $camera->getId()]);
        }

        return $this->render('camera/new.html.twig', [
          'camera' => $camera,
          'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a Camera entity.
     * @Route(
     *     "/{id}",
     *     name="camera_show",
     *     methods={"GET"},
     *     requirements={"id" = "\d+"}
     * )
     *
     * @param \AppBundle\Entity\Camera $camera
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Camera $camera)
    {
        return $this->render('camera/show.html.twig', [
          'camera' => $camera,
        ]);
    }

    /**
     * Displays a form to edit an existing camera entity.
     *
     * @Route(
     *     "camera/{id}/edit",
     *     name="camera_edit",
     *     methods={"GET", "POST"},
     *     requirements={"id" = "\d+"}
     * )
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \AppBundle\Entity\Camera $camera
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Camera $camera)
    {
        $this->denyAccessUnlessGranted(CameraVoter::EDIT, $camera);

        $form = $this->createForm(CameraType::class, $camera);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('camera_edit',
              ['id' => $camera->getId()]);
        }

        return $this->render('camera/edit.html.twig', [
          'camera' => $camera,
          'form' => $form->createView(),
        ]);
    }

    /**
     * Deletes a Camera entity.
     * @Route(
     *     "camera/{id}",
     *     name="camera_delete",
     *     methods={"DELETE"},
     *     requirements={"id" = "\d+"}
     * )
     *
     * @param \AppBundle\Entity\Camera $camera
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Camera $camera)
    {
        if (!$camera) {
            throw new NotFoundHttpException('No camera found');
        }

        $user = $this->getUser();
        if ($user->getId() !== $camera->getUser()->getId()) {
            throw new AccessDeniedHttpException("You cannot delete a camera you haven't added");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($camera);
        $em->flush();

        return $this->redirectToRoute('user_show', [
          'id' => $user->getId(),
        ]);
    }
}
