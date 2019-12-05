<?php

namespace App\Controller;

use App\Entity\Board;
use App\Entity\Column;
use App\Form\ColumnType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ColumnController extends AbstractController
{

    /**
     * @Route("/board/{board}/column/new", name="column_new", methods={"GET", "POST"})
     */
    public function addColumn(Request $request, Board $board)
    {
        $form = $this->createForm(ColumnType::class, null, ['board' => $board]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $column = new Column();

            $column->setTitle($data['title']);
            $column->setBoard($board);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($column);
            $entityManager->flush();

            return $this->redirectToRoute('board_show', [
                'id' => $board->getId()
            ]);
        }

        return $this->render('board/column/new.html.twig', [
            'form' => $form->createView(),
            'board' => $board
        ]);
    }
}
