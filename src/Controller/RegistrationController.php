<?php

namespace App\Controller;

use App\Entity\User;
use Gumlet\ImageResize;
use App\Security\Authenticator;
use App\Form\RegistrationFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, Authenticator $authenticator): Response
    {
        // Je stoque dans un variable l'url de mon dossier public
        $public = $this->getParameter('kernel.project_dir') . '/public/';
        $imgOK  = false;
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // test du fichier uploadé
            if (!empty($_FILES['registration_form']) && isset($_FILES['registration_form'])) {

                $files = $_FILES['registration_form'];

                // test des différents types d'erreur (type,size,error) qui peuvent êtres fait séparement
                if ($files['type']['avatar'] === 'image/jpeg' || $files['type']['avatar'] === 'image/jpg' || $files['type']['avatar'] === 'image/gif' || $files['type']['avatar'] === 'image/png' || $files['type']['avatar'] === 'image/webp') {

                    $tmpImg = $public . "assets/images/upload/" . $files['name']['avatar'];
                    move_uploaded_file($files['tmp_name']['avatar'], $tmpImg);
                    $imgOK = true;
                } else {
                    //$erreur['coverImg'] =  "Le fichier coverImg n'est pas au bon format.";
                }
            }
            // attribuer un ROLE_USER auto
            $user->setRoles(['ROLE_USER']);
            //comparaison des passwords
            if ($form->get('plainPassword')->getData() === $form->get('confirmPassword')->getData()) {
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                // do anything else you need here, like send an email
                if ($imgOK) {
                    $idUser = $user->getId();
                    //ImageResize
                    $avatar = new ImageResize($tmpImg);
                    $avatar->resizeToWidth(400);
                    $avatar->save($public . "assets/images/users/" . $idUser . ".webp", IMAGETYPE_WEBP);
                    $avatarth = new ImageResize($tmpImg);
                    $avatarth->resizeToWidth(80);
                    $avatarth->save($public . "assets/images/users/thumbnail/" . $idUser . ".webp", IMAGETYPE_WEBP);
                    // unlink je supprime l'image d'origine
                    unlink($tmpImg);
                    // update
                    $user->setAvatar($idUser . ".webp");
                    $entityManager = $this->getDoctrine()->getManager()->flush();
                }
                return $guardHandler->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $authenticator,
                    'main' // firewall name in security.yaml
                );
            } else {
                return $this->render('registration/register.html.twig', [
                    'registrationForm' => $form->createView(),
                    'passError' => "Passwords don't appear to match. "
                ]);
            }
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
