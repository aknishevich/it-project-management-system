<?php

namespace App\Controller;

use App\Entity\LoggedTime;
use App\Entity\User;
use App\Form\LoggedTimeFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/logged_time", name="logged_time", methods={"GET"})
     */
    public function loggedTime()
    {
        $user = $this->getUser();
        $loggedTime = $user->getLoggedTime()->toArray();

        return $this->render('user/log_time/time.html.twig', [
            'loggedTime' => $loggedTime
        ]);
    }

    /**
     * @Route("/log_time", name="log_time", methods={"GET", "POST"})
     */
    public function logTime(Request $request)
    {
        $user = $this->getUser();
        $loggedTime = new LoggedTime();
        $tasks = $user->getAvailableTasks();
        $timeForm = $this->createForm(LoggedTimeFormType::class, $loggedTime, ['tasks' => $tasks]);
        $timeForm->handleRequest($request);
        if ($timeForm->isSubmitted() && $timeForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $loggedTime->setUser($user);
            $entityManager->persist($loggedTime);
            $entityManager->flush();

            return $this->redirectToRoute('logged_time');
        }

        return $this->render('user/log_time/log.html.twig', [
            'form' => $timeForm->createView()
        ]);
    }
}