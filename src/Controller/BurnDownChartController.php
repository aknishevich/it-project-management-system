<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/burndown")
 */
class BurnDownChartController extends AbstractController
{
    /**
     * @Route("/", name="burndown_index")
     */
    public function index()
    {
        return $this->render('burndown/index.html.twig', []);
    }

}