<?php

namespace App\Controller\Back;

use App\Entity\Brewerie;
use App\Form\BrewerieType;
use App\Repository\BrewerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Routes that manage the breweries in the backoffice, linked to the database
 * 
 * @Route("/back/brewerie")
 */
class BrewerieController extends AbstractController
{
    /**
     * Route to the list of all breweries
     * 
     * @Route("/", name="app_back_brewerie_index", methods={"GET"})
     */
    public function index(BrewerieRepository $brewerieRepository): Response
    {
        // view is rendered with the index.html.twig template in template/back/brewerie
        return $this->render('back/brewerie/index.html.twig', [
            // uses the findBy method of the BrewerieRepository
            'breweries' => $brewerieRepository->findBy(
                [],
                ['name' => 'ASC'] // order the list of breweries in alphabetical order by name
            ),

        ]);
    }


    /**
     * Route for creating a new brewery
     * 
     * @Route("/new", name="app_back_brewerie_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BrewerieRepository $brewerieRepository): Response
    {
        $brewerie = new Brewerie();
        $form = $this->createForm(BrewerieType::class, $brewerie); // use the form created with the class BrewerieType
        $form->handleRequest($request); // handleRequest read form data off of the superglobals $_POST configured on the form

        if ($form->isSubmitted() && $form->isValid()) 
        {
            // if the form is valid and submitted, the brewery is added to the database
            $brewerieRepository->add($brewerie, true);

            // send a flash message to inform that the brewery was succefully created
            $this->addFlash('success', 'Enregistrement créé.'); 

            // redirect to the brewery index in the backoffice
            // 303 See Other redirect status response code indicates that the redirects don't link to the requested resource itself
            return $this->redirectToRoute('app_back_brewerie_index', [], Response::HTTP_SEE_OTHER); 
        }

        // render the form with the template new.html.twig in template/back/brewerie
        return $this->renderForm('back/brewerie/new.html.twig', 
        [
            'brewerie' => $brewerie,
            'form' => $form,
        ]);
    }

    /**
     * Route for viewing a brewery
     * 
     * @Route("/{id<\d+>}", name="app_back_brewerie_show", methods={"GET"})
     */
    public function show(Brewerie $brewerie=null): Response
    {

        // if the brewery doesn't exist, an exception is thrown to inform that it doesn't exist
        if ($brewerie === null) 
        {
            throw $this->createNotFoundException('Brasserie non trouvée.');
        }
        
        // if the brewery exists, the view is rendered with the template show.html.twig in template/back/brewerie
        return $this->render('back/brewerie/show.html.twig', 
        [
            'brewerie' => $brewerie, // uses the brewerie entity to dynamise the view
        ]);
    }

    /**
     * Route for editing a brewery
     * 
     * @Route("/{id<\d+>}/edit", name="app_back_brewerie_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Brewerie $brewerie = null, BrewerieRepository $brewerieRepository): Response
    {
        // if the brewery doesn't exist, an exception is thrown to inform that it doesn't exist
        if ($brewerie === null) 
        {
            throw $this->createNotFoundException('Brasserie non trouvée.');
        }
        
        // use the form created with the class BrewerieType
        $form = $this->createForm(BrewerieType::class, $brewerie);
        // handleRequest read form data off of the superglobals $_POST configured on the form
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            // if the form is valid and submitted, the brewery is updated to the database
            $brewerieRepository->add($brewerie, true);

            // redirect to the brewery index in the backoffice
            // 303 See Other redirect status response code indicates that the redirects don't link to the requested resource itself
            return $this->redirectToRoute('app_back_brewerie_index', [], Response::HTTP_SEE_OTHER);
        }

        // render the form with the template edit.html.twig in template/back/brewerie and uses $form to generate the form and $brewerie to dynamise the brewery datas
        return $this->renderForm('back/brewerie/edit.html.twig', [
            'brewerie' => $brewerie,
            'form' => $form,
        ]);
    }

    /**
     * Route for deleting a brewery from the database
     * 
     * @Route("/{id<\d+>}/delete", name="app_back_brewerie_delete", methods={"POST"})
     */
    public function delete(Request $request, Brewerie $brewerie = null, BrewerieRepository $brewerieRepository): Response
    {
        // if the brewery doesn't exist, an exception is thrown to inform that it doesn't exist
        if ($brewerie === null) {
            throw $this->createNotFoundException('Brasserie non trouvée.');
        }
        
        // verify that the CSRF token is the same as the one generated with the form 
        if ($this->isCsrfTokenValid('delete'.$brewerie->getId(), $request->request->get('_token'))) {
            $brewerieRepository->remove($brewerie, true);
            $this->addFlash('success', 'Enregistrement supprimé.');
        }

        // redirect to the brewery index in the backoffice
        // 303 See Other redirect status response code indicates that the redirects don't link to the requested resource itself
        return $this->redirectToRoute('app_back_brewerie_index', [], Response::HTTP_SEE_OTHER);
    }


}