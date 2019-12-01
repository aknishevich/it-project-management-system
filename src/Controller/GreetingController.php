<?php


namespace App\Controller;


use App\Entity\Time;
use App\Repository\TimeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GreetingController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('base.html.twig', []);
    }

    /**
     * @Route("/greeting", name="greeting")
     */
    public function greeting(UserRepository $userRepository)
    {
        $userName = $userRepository->findOneBy(['email' => 'aknishevich@gmail.com'])->getName();
        return $this->render('greeting/greeting.html.twig', ['searchUser' => $userName]);
    }
}