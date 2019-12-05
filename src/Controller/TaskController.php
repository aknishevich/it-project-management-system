<?php

namespace App\Controller;

use App\Entity\Board;
use App\Entity\Task;
use App\Entity\User;
use App\Form\TaskType;
use App\Repository\ColumnRepository;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/board/{board}/task")
 */
class TaskController extends AbstractController
{
    private $userRepository;
    private $columnRepository;
    private $taskRepository;

    public function __construct(UserRepository $userRepository, ColumnRepository $columnRepository, TaskRepository $taskRepository)
    {
        $this->userRepository = $userRepository;
        $this->columnRepository = $columnRepository;
        $this->taskRepository = $taskRepository;
    }

    /**
     * @Route("/", name="task_index", methods={"GET"})
     */
    public function index(Board $board): Response
    {
        return $this->render('task/index.html.twig', [
            'tasks' => $this->taskRepository->findBy(['board' => $board->getId()]),
            'board' => $board
        ]);
    }

    /**
     * @Route("/new", name="task_new", methods={"GET","POST"})
     */
    public function new(Board $board, Request $request): Response
    {
        $form = $this->createForm(TaskType::class,null, [
            'board' => $board,
            'action' => $this->generateUrl('task_new', [
                'board' => $board->getId()
            ])
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $task = new Task();

            if (($assignee = $this->userRepository->find($data['assignee'])) && $assignee->isBoardAvailable($board)) {
                $task->setAssignee($assignee);
            }

            $task->setTitle($data['title']);
            $task->setDescription($data['description']);
            if (($currentUser = $this->getUser()) && $currentUser instanceof User) {
                $task->setReporter($currentUser);
            }

            $task->setBoard($board);
            if ($this->columnRepository->findBy(['id' => $data['status'], 'board' => $board->getId()])) {
                $task->setStatus($data['status']);
            }

            $task->setEstimate($data['estimate']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('board_show', ['id' => $board->getId()]);
        }

        return $this->render('task/_form.html.twig', [
            'board' => $board,
            'members' => $board->getMembers()->toArray(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="task_show", methods={"GET"})
     */
    public function show(Board $board, Task $task): Response
    {
        return $this->render('task/show.html.twig', [
            'task' => $task,
            'board' => $board
        ]);
    }

    /**
     * @Route("/{id}/edit", name="task_edit", methods={"GET","POST"})
     */
    public function edit(Board $board, Request $request, Task $task): Response
    {
        $form = $this->createForm(TaskType::class, $task, [
            'board' => $board,
            'action' => $this->generateUrl('task_edit', [
                'board' => $board->getId(),
                'id' => $task->getId()
            ])
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('board_show', ['id' => $board->getId()]);
        }

        return $this->render('task/_form.html.twig', [
            'task' => $task,
            'board' => $board,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="task_delete", methods={"DELETE"})
     */
    public function delete(Board $board, Request $request, Task $task): Response
    {
        if ($this->isCsrfTokenValid('delete'.$task->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($task);
            $entityManager->flush();
        }

        return $this->redirectToRoute('task_index');
    }
}
