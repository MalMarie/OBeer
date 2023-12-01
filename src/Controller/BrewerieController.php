<?php

namespace App\Controller;

use App\Entity\Brewerie;
use App\Repository\BrewerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BrewerieController extends AbstractController
{
 
    /**
     * Road for reach all breweries by list 
     * 
     * @Route("/brasseries/liste", name="app_breweries_list")
     */
    public function list(BrewerieRepository $brewerieRepository): Response
    {
        // Get all breweries in alphabetical order of states and name with findAllOrderedByStateAscDql from BrewerieRepository
        $breweries = $brewerieRepository->findAllOrderedByStateAscDql();

        // Redirect to template list.html.twig
        return $this->render('brewerie/list.html.twig', 
        [
           'breweries' => $breweries,
        ]);
    }

    /**
     * Road for reach one brewerie information
     * 
     * @Route("/brasseries/{id}", name="app_brewerie_show", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function show(int $id, BrewerieRepository $brewerieRepository)
    {
        // Get the brewerie by its id in database -> findBy = method created in repository 
        $breweries = $brewerieRepository->findBy(['id' => $id]);

        // Redirect to template show.html.twig
        return $this->render('brewerie/show.html.twig', 
        [
            'breweries' => $breweries
        ]);
    }

    /**
     * Road to get breweries by state 
     * 
     * @Route("brasseries/{state}", name="app_brewerie_bystate", methods={"GET"})
     */
    public function brewerieByState(BrewerieRepository $brewerieRepository, string $state): Response
    {
        // Get and order breweries by state 
        $breweries = $brewerieRepository->findByState($state);
        
        // Redirect to template bystate.html.twig
        return $this->render('brewerie/bystate.html.twig', [
           'breweries' => $breweries,
        ]);
    }   
}
