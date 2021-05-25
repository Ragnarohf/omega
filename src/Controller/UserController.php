<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Gumlet\ImageResize;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        return $this->redirectToRoute('app_register');
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $public = $this->getParameter('kernel.project_dir') . '/public/';
        $imgOK  = false;
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (!empty($_FILES['user']) && isset($_FILES['user'])) {

                $files = $_FILES['user'];

                // test des différents types d'erreur (type,size,error) qui peuvent êtres fait séparement
                if ($files['type']['avatar'] === 'image/jpeg' || $files['type']['avatar'] === 'image/jpg' || $files['type']['avatar'] === 'image/gif' || $files['type']['avatar'] === 'image/png' || $files['type']['avatar'] === 'image/webp') {

                    $tmpImg = $public . "assets/images/upload/" . $files['name']['avatar'];
                    move_uploaded_file($files['tmp_name']['avatar'], $tmpImg);
                    $imgOK = true;
                } else {
                    //$erreur['coverImg'] =  "Le fichier coverImg n'est pas au bon format.";
                }
            }
            if ($imgOK) {
                // dd('hello');
                $idUser = $user->getId();
                //ImageResize
                $avatar = new ImageResize($tmpImg);
                $avatar->resizeToWidth(400);
                $avatar->save($public . "assets/images/users/" . $idUser . ".webp", IMAGETYPE_WEBP);
                $avatarth = new ImageResize($tmpImg);
                $avatarth->resizeToWidth(80);
                $avatarth->save($public . "assets/images/users/thumbnail/" . $idUser . ".webp", IMAGETYPE_WEBP);
                // unlink je supprime l'image d'origine
                // unlink($tmpImg);
                // update
                $user->setAvatar($idUser . ".webp");
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
