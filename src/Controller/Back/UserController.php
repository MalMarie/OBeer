<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\UserEditType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Routes that manage the users in the backoffice, linked to the database
 * 
 * @Route("/back/user")
 */
class UserController extends AbstractController
{
    /**
     * Route to the list of all users
     * 
     * @Route("/", name="app_back_user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        // view is rendered with the index.html.twig template in template/back/brewerie
        return $this->render('back/user/index.html.twig', 
        [
            // uses the findAll method of the UserRepository
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * Route for creating a new user
     * 
     * @Route("/new", name="app_back_user_new", methods={"GET", "POST"})
     */
    public function new(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        // use the form created with the class UserType
        $form = $this->createForm(UserType::class, $user);

        // handleRequest read form data off of the superglobals $_POST configured on the form
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {

            // the password is hashed with the service UserPassewordHasherInterface
            // the plaintext password is in $user, updated by the form
            // and so has the written password in the form routed with the HTTP request
            $plainTextPassword = $user->getPassword();

            // hashed password
            $hashedPassword = $passwordHasher->hashPassword($user, $plainTextPassword); // the same as PHP's password_hash()

            // we overwrite the plaintext password with the hashed one in the $user object
            $user->setPassword($hashedPassword);

            // we save in database
            $userRepository->add($user, true);

            // redirect to the user index in the backoffice
            // 303 See Other redirect status response code indicates that the redirects don't link to the requested resource itself
            return $this->redirectToRoute('app_back_user_index', [], Response::HTTP_SEE_OTHER);
        }

        // render the form with the template new.html.twig in template/back/user
        return $this->renderForm('back/user/new.html.twig', 
        [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * Route for viewing a user
     * 
     * @Route("/{id<\d+>}", name="app_back_user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        // if the user doesn't exist, an exception is thrown to inform that it doesn't exist
        if ($user === null) 
        {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        // if the user exists, the view is rendered with the template show.html.twig in template/back/user
        return $this->render('back/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * Route for editing a user
     * 
     * @Route("/{id<\d+>}/edit", name="app_back_user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        // if the user doesn't exist, an exception is thrown to inform that it doesn't exist
        if ($user === null) 
        {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        // use the form created with the class UserType
        $form = $this->createForm(UserType::class, $user);
        // handleRequest read form data off of the superglobals $_POST configured on the form
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {

            // if we need to replace the password, if the 
            // form is submitted, we hash and replace
            if ($form->get('password')->getData()) 
            {
                // we get the unmapped password from the form
                $plainTextPassword = $form->get('password')->getData(); // $plainTextPassword = $_POST['password'];
                $hashedPassword = $passwordHasher->hashPassword($user, $plainTextPassword); // password_hash() de PHP
                // set the hashed password to the $user
                $user->setPassword($hashedPassword);
            }
            // if the form is valid and submitted, the user is updated to the database
            $userRepository->add($user, true);
            
            // redirect to the brewery index in the backoffice
            // 303 See Other redirect status response code indicates that the redirects don't link to the requested resource itself
            return $this->redirectToRoute('app_back_user_index', [], Response::HTTP_SEE_OTHER);
        }

        // render the form with the template edit.html.twig in template/back/user and uses $form to generate the form and $user to dynamise the user datas
        return $this->renderForm('back/user/edit.html.twig', 
            [
                'user' => $user,
                'form' => $form,
            ]);
    }

    /**
    * Route for deleting a user from the database
    * 
    * @Route("/{id<\d+>}/delete", name="app_back_user_delete", methods={"POST"})
    */
    public function delete(Request $request, User $user, UserRepository $userRepository ): Response
    {
        // if the user doesn't exist, an exception is thrown to inform that it doesn't exist
        if ($user === null) 
        {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        // verify that the CSRF token is the same as the one generated with the form 
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) 
        {
            $userRepository->remove($user, true);
            $this->addFlash('success', 'Enregistrement supprimé.');
        }

        // redirect to the user index in the backoffice
        // 303 See Other redirect status response code indicates that the redirects don't link to the requested resource itself
        return $this->redirectToRoute('app_back_user_index', [], Response::HTTP_SEE_OTHER);
    }
}