<?php /** @noinspection PhpParamsInspection */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Admin controller.
 *
 * @Route("/admin")
 */
class AdminController extends Controller
{

    /**
     * Show admin main page.
     * @Route("/", name="admin_index", methods={"GET"})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $users = $this->getDoctrine()
          ->getRepository(User::class)
          ->findAll();

        return $this->render('admin/index.html.twig', ['users' => $users]);
    }

    /**
     * Restrict a user from posting new offers.
     * @Route(
     *     "/restrict/{id}",
     *     name="admin_restrict",
     *     methods={"GET"},
     *     requirements={"id" = "\d+"}
     * )
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function restrictAction(User $user)
    {
        if (!$user) {
            throw new NotFoundHttpException("No such user exists.");
        }

        $user->setIsRestricted(!$user->isRestricted());
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('admin_index');
    }
}
