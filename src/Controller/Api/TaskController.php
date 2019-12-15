<?php


namespace App\Controller\Api;


use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class TaskController extends AbstractController
{
    /**
     * @Route("/task/{id}", name="api_get_task", methods={"GET"})
     */
    public function getTask(Task $task): JsonResponse
    {
        return new JsonResponse(['data' => $task->asArray()]);
    }
}