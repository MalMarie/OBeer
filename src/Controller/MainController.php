<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    /**
     * Road to homepage 
     * 
     * @Route("/", name="app_main_index")
     */
    public function index(): Response
    {   
        // Redirect to template index.html.twig
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }


    /**
     *  Road to history page 
     *  
     * @Route("/histoire", name="app_main_histoire")
     */
    public function history(): Response
    {   
        // Redirect to template history.html.twig
        return $this->render('main/history.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * Road to legals template 
     *  
     * @Route("/mentions-legales", name="app_main_mentions_legales")
     */
    public function legals(): Response
    {
        // Redirect to template mentions.html.twig
        return $this->render('main/mentions.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }


    
    /**
     *  
     * Road to team template  
     * 
     * @Route("/equipe", name="app_main_equipe")
     */
    public function team(): Response
    {
        // Redirect to template team.html.twig
        return $this->render('main/team.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     *  
     * Road to contacts template 
     * 
     * @Route("/contacts", name="app_main_contacts")
     */
    public function contact(): Response
    {
        // Redirect to template contact.html.twig 
        return $this->render('main/contacts.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

     /**
     *  
     * Road to show a popup before homepage. 
     * 
     * @Route("/pop-up", name="app_main_pop-up")
     */
    public function popup(): Response
    {
        // Redirect to template popup.html.twig
        return $this->render('main/popup.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

}
