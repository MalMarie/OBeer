<?php

namespace App\Controller;

use App\Entity\Brewerie;
use App\Repository\BrewerieRepository;
use App\Service\FavoritesManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class FavoritesController extends AbstractController
{   

    private $favoritesmanager;    
    public function __construct(FavoritesManager $favoritesManager)
    {   
        // Get instance of favoritesManager by $favoritesManager as a service 
        $this->favoritesmanager = $favoritesManager;
    }


    /**
     * Road to the favorites user list 
     * 
     * @Route("/favoris/liste", name="app_favorites_list", methods={"GET"})
     */
    public function list(): Response
    {
        // Redirect to the template list.html.twig
        return $this->render('favorites/list.html.twig');
    }

    /**
     * Add brewerie to favorites
     * 
     * @param int $id brewerie id
     * 
     * @Route("/favoris/add/{id<\d+>}", name="app_favorites_add", methods={"GET"})
     * @see https://symfony.com/doc/5.4/session.html#basic-usage
     */
    public function add(int $id, Brewerie $brewerie = null)
    {
        
        // Handle the case that the searched brewery doesn't exist 
        if ($brewerie === null) 
        {
            throw $this->createNotFoundException('Brasserie indisponible');
        }

        // Call of function "add" from the favoritesManager + message if the brewerie is added 
        if ($this->favoritesmanager->add($id, $brewerie) == 'added') 
        {
            $this->addFlash('success', "{$brewerie->getName()} a été ajouté à votre liste de favoris.");
        } 
        // Call of function "add" from the favoritesManager + message if the brewerie is already added
        elseif ($this->favoritesmanager->add($id, $brewerie) == 'already added') 
        {
            $this->addFlash('warning', "{$brewerie->getName()} existait déjà dans votre liste de favoris.");
        }

        // Redirect to the template list.html.twig from favorites
        return $this->redirectToRoute('app_favorites_list', ['brewerie' => $brewerie]);
    }
        

    /**
    * Method to clear all favorites from the list 
    * 
    * @Route("/favoris/suppression", name="app_favorites_clear", methods={"GET"}))
    */
    public function clear()
    {   
            // Call of clear method from FavoritesManager 
            $this->favoritesmanager->clear();

            // Message flash for confirm clearing
            $this->addFlash('success', "Votre liste de favoris a été supprimée.");

            // Redirect to the template list.html.twig
            return $this->redirectToRoute('app_favorites_list');
    }

    /**
    * Methode to delete one brewerie from favorites list 
    *
    * @Route("/favoris/suppresion-element/{id<\d+>}", name="app_favorites_remove", methods={"GET"})
    * 
    * @return void
    */
    public function remove(int $id, Brewerie $brewerie = null)
    {
            // Call of removeFavorite methode from FavoritesManager 
            $this->favoritesmanager->removeFavorite($id);
            // Add a flash message to confirm deletion
            $this->addFlash('success', "{$brewerie->getName()} a bien été supprimée.");
            // Redirect to the template list.html.twig
            return $this->redirectToRoute('app_favorites_list');
    }
}
