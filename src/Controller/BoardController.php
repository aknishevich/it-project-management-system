<?php

namespace App\Controller;

use App\Entity\Board;
use App\Entity\User;
use App\Form\BoardType;
use App\Repository\BoardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

/**
 * @Route("/board")
 */
class BoardController extends AbstractController
{

    /**
     * @Route("/", name="board_index", methods={"GET"})
     */
    public function index(BoardRepository $boardRepository): Response
    {
        return $this->render('board/index.html.twig', [
            'boards' => $this->getUser()->getAvailableBoards()
        ]);
    }

    /**
     * @Route("/new", name="board_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $form = $this->createForm(BoardType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $board = $form->getData();
            $author = $this->getUser();

            if (!$author instanceof User) {
                throw new UnsupportedUserException('Logged user instance of ' . get_class($author) .'. Should be instance of ' . User::class . ' class');
            }

            $board->setAuthor($author);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($board);
            $entityManager->flush();

            return $this->redirectToRoute('board_index');
        }

        return $this->render('board/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="board_show", methods={"GET"})
     */
    public function show(Board $board): Response
    {
        if (!$this->getUser()->isBoardAvailable($board)) {
            throw new AccessDeniedException('You do not have sufficient permissions to view this board.');
        }

        return $this->render('board/show.html.twig', [
            'board' => $board,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="board_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Board $board): Response
    {
        if (!$this->getUser()->isAuthor($board)) {
            throw new AccessDeniedException('You\'re not board author and do not have permissions to edit this board.');
        }

        $form = $this->createForm(BoardType::class, $board);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('board_index');
        }

        return $this->render('board/edit.html.twig', [
            'board' => $board,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="board_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Board $board): Response
    {
        if (!$this->getUser()->isAuthor($board)) {
            throw new AccessDeniedException('You\'re not board author and do not have permissions to delete this board.');
        }

        if ($this->isCsrfTokenValid('delete'.$board->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($board);
            $entityManager->flush();
        }

        return $this->redirectToRoute('board_index');
    }
}
