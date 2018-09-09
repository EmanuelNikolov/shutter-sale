<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Camera;
use AppBundle\Form\CameraType;
use AppBundle\Repository\CameraRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $camera = new Camera();
        $form = $this->createForm('AppBundle\Form\CameraType', $camera);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($camera);
            $em->flush();

            return $this->redirectToRoute('camera_show', ['id' => $camera->getId()]);
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
     * @param \AppBundle\Entity\Camera $camera
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Camera $camera)
    {
        $deleteForm = $this->createDeleteForm($camera);

        return $this->render('camera/show.html.twig', [
          'camera' => $camera,
          'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing camera entity.
     *
     * @Route(
     *     "camera/{id}/edit",
     *     name="camera_edit",
     *     methods={"GET"},
     *     requirements={"id" = "\d+"}
     * )
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \AppBundle\Entity\Camera $camera
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Camera $camera)
    {
        $deleteForm = $this->createDeleteForm($camera);
        $editForm = $this->createForm(CameraType::class, $camera);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('camera_edit', ['id' => $camera->getId()]);
        }

        return $this->render('camera/edit.html.twig', [
          'camera' => $camera,
          'edit_form' => $editForm->createView(),
          'delete_form' => $deleteForm->createView(),
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
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \AppBundle\Entity\Camera $camera
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Camera $camera)
    {
        $form = $this->createDeleteForm($camera);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($camera);
            $em->flush();
        }

        return $this->redirectToRoute('camera_index');
    }

    /**
     * Creates a form to delete a Camera entity.
     * @param Camera $camera The camera entity
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(Camera $camera)
    {
        return $this->createFormBuilder()
          ->setAction($this->generateUrl('camera_delete', ['id' => $camera->getId()]))
          ->setMethod('DELETE')
          ->getForm();
    }
}
