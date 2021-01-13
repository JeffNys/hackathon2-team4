<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/majapi", name="api")
     */
    public function api(): Response
    {
        // de Jeff, je vais faire la mise à jour de la BDD depuis l'API ici

        return $this->render('home/api.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
