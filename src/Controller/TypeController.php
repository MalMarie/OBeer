<?php

namespace App\Controller;

use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TypeController extends AbstractController
{
    /**
     * Route to beer type template
     * 
     * @Route("/type-biere", name="app_type_index")
     */
    public function index(): Response
    {
        // Redirect to type.html.twig                 
        return $this->render('type/type.html.twig');
    }
}

