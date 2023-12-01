<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo')
            ->add('birthdate', BirthdayType::class)
            ->add('email')
            ->add('password')
      
        ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            // Stock all data of the form in $form, get from event
            $form = $event->getForm();
            // Get the user concerned 
            $user = $event->getData();
            // check if the user is existing or not 
            if ($user->getId() !== null) {
                // If user exist then -> edit
                $form->add('email', EmailType::class, [
                    'invalid_message' => 'L\'email doit avoir le format correct',
                    'label' => 'E-mail',
                    // If email value is "null" we consider as an empty string 
                    // the the data will be handle by the Validator 
                    'empty_data' => '',
                    'constraints' => 
                    [
                        new Assert\NotBlank(),
                        new Assert\Email()
                    ],
                ])
          
                ->add('password', null, [
                    'label' => 'Nouveau mot de passe',
                    // the form is no longer manage this property, it's just a field not linked to the entity
                    'mapped' => false,
                    'constraints' => 
                    [
                        new Assert\NotBlank(),
                        new Assert\Length(['min' => 6, 'max' => 255])
                    ],
                ]);
            }
            else {
                $form->add('password', RepeatedType::class, [
                    // repeated type fiel
                    'type' => PasswordType::class,
                    // error message
                    'invalid_message' => 'Les mots de passe ne correspondent pas.',
                    'options' => ['attr' => ['class' => 'password-field']],
                    'required' => true,
                    // option for the first field (the one transfered to the back)
                    'first_options'  => ['label' => 'Mot de passe'],
                    // options for the second field
                    'second_options' => ['label' => 'Confirmer le mot de passe'],
                    'constraints' => 
                    [
                        new Assert\NotBlank(),
                        new Assert\Length(['min' => 6, 'max' => 255])
                    ],
                ]);
            }
        })
        ->add('password', RepeatedType::class, [
            // repeated type fiel
            'type' => PasswordType::class,
            // error message
            'invalid_message' => 'Les mots de passe ne correspondent pas.',
            'options' => ['attr' => ['class' => 'password-field']],
            'required' => true,
            // option for the first field (the one transfered to the back)
            'first_options'  => ['label' => 'Mot de passe'],
            // options for the second field
            'second_options' => ['label' => 'Confirmer le mot de passe'],
            'constraints' =>
            [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 6, 'max' => 255])
            ],
        ]);
    
}
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        // setDefaults is mostly useful if you want to reuse the default values set in parent classes in sub-classes
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
