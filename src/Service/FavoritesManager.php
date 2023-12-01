<?php

namespace App\Service;

use App\Entity\Brewerie;
use App\Repository\BrewerieRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Service that manages the favorites breweries in a session 
 */
class FavoritesManager
{
    private $session;
    private $brewerieRepository;

    public function __construct(SessionInterface $session, BrewerieRepository $brewerieRepository)
    {
        // Setup the session 
        $this->session = $session;
        $this->brewerieRepository = $brewerieRepository;
    }

    /**
     * Method for adding favorites breweries and stock in session
     *
     * @return void
     */
    public function add(int $id, Brewerie $brewerie = null)
        {
                  
        // Declare $favorites as an array 
        $favorites = $this->session->get('favorites', []);

        // Condition that verify if the brewery is already added to favorites
        // if not the brewery is added on the list
        if (!array_key_exists($id, $favorites)) 
        {
            // add the favorite in the array using id of the brewery
            $favorites[$id] = $brewerie;
            // update the favorites list
            $this->session->set('favorites', $favorites);
            // Return the message "added" from flash message
            return 'added';

        }
        // If exists, the method doesn't modify the favorites list
        else 
        {
            // Return flash message "already added"
            return 'already added';
        }
        
    }

    /**
     * Method to clear all favorites from the list in the session 
     *
     * @return void
     * 
     */
    public function clear()
    {
        $this->session->remove('favorites');
    }

    /**
     * Method to delete one brewerie from the favorite list
     *
     * @param integer $id
     * @return void
     */
    public function removeFavorite(int $id)
    {
        // Getting the list of the favorites brewerie added in the session
        $favorites = $this->session->get('favorites', []);
        // Using "unset" method to delete the brewerie depending on the id associated
        unset($favorites[$id]);
        // update of the favorites list
        $this->session->set('favorites', $favorites);
    }
}