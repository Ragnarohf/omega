<?php

namespace App\Controller;

use App\Entity\ListFriend;
use App\Form\ListFriendType;
use App\Repository\ListFriendRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/list/friend")
 */
class ListFriendController extends AbstractController
{
    /**
     * @Route("/", name="list_friend_index", methods={"GET"})
     */
    public function index(ListFriendRepository $listFriendRepository): Response
    {
        return $this->render('list_friend/index.html.twig', [
            'list_friends' => $listFriendRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="list_friend_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $listFriend = new ListFriend();
        $form = $this->createForm(ListFriendType::class, $listFriend);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($listFriend);
            $entityManager->flush();

            return $this->redirectToRoute('list_friend_index');
        }

        return $this->render('list_friend/new.html.twig', [
            'list_friend' => $listFriend,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="list_friend_show", methods={"GET"})
     */
    public function show(ListFriend $listFriend): Response
    {
        return $this->render('list_friend/show.html.twig', [
            'list_friend' => $listFriend,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="list_friend_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ListFriend $listFriend): Response
    {
        $form = $this->createForm(ListFriendType::class, $listFriend);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('list_friend_index');
        }

        return $this->render('list_friend/edit.html.twig', [
            'list_friend' => $listFriend,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="list_friend_delete", methods={"POST"})
     */
    public function delete(Request $request, ListFriend $listFriend): Response
    {
        if ($this->isCsrfTokenValid('delete'.$listFriend->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($listFriend);
            $entityManager->flush();
        }

        return $this->redirectToRoute('list_friend_index');
    }
}
