<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MonitorController extends AbstractController
{
    /**
     * @Route("/", name="monitor")
     */
    public function index()
    {
        return $this->render('monitor/index.html.twig', [
            'controller_name' => 'MonitorController',
        ]);
    }
}
