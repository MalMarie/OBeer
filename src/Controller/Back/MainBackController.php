<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainBackController extends AbstractController
{
    /**
     * Route to the backoffice main menu
     * 
     * @Route("/back", name="app_main_back")
     */
    public function index(): Response
    {
        // view is rendered with the index.html.twig template in template/back/
        return $this->render('back/index.html.twig', [
            'controller_name' => 'MainBackController',
        ]);
    }
}
