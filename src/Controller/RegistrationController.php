<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class RegistrationController extends AbstractController
{

     /**
     * @Route("/utilisateur/nouveau", name="app_user_new", methods={"GET", "POST"})
     */
    public function new(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        // Call of entity User 
        $user = new User();

        // Method to create the form using class RegistrationType
        $form = $this->createForm(RegistrationType::class, $user);

        // Handle the submit 
        $form->handleRequest($request);

            // Check if the form is submitted (if an user has been added) or not
            if ($form->isSubmitted() && $form->isValid()) 
            {
                // Hashing the password by Symfony method 'hashPassword'
                // Stock the password in $user as an object 
                $plainTextPassword = $user->getPassword();
                
                $hashedPassword = $passwordHasher->hashPassword($user, $plainTextPassword); // PHP's password_hash()
                // Replace the plaintext password by hashed password
                $user->setPassword($hashedPassword);

                // saving in database.
                $userRepository->add($user, true);
                // Flash message to confirm the user creation
                $this->addFlash('success', "Compte créé. Veuillez vous connecter, s'il vous plaît.");
                
                // Redirect to homepage 
                // HTTP_SEE_OTHER = 303 
                return $this->redirectToRoute('app_main_index', [], Response::HTTP_SEE_OTHER);
            }
        // Render the RegistrationType (form) and show message if invalid parameters found
        return $this->renderForm('registration/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}