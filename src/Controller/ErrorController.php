<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\HttpUtils;

class ErrorController extends AbstractController
{
    /**
     * Road to 404 error page 
     * 
     * @Route("/erreur", name="app_errors")
     */
    public function error(FlattenException $exception): Response
    {   
        // Method of ErrorHandler to get error status 
        $code = $exception->getStatusCode();
        
        // Condition to generate error message + return appropriate template
        if ($code = '404' )
        {
            $code = 404;
            $response = new Response();
            $response->setStatusCode(404);

            // Redirect to template error404.html.twig
            return $this->render('error/error404.html.twig', 
            [
                'controller_name' => 'ErrorController',
            ]);
        }
        elseif ($code = '403' )
        {
            $code = 403;
            $response = new Response();
            $response->setStatusCode(403);

            // Redirect to template error403.html.twig
            return $this->render('error/error403.html.twig',
            [
                'controller_name' => 'ErrorController'
            ]);
        }
    }
}
