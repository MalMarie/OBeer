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

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo')
            ->add('birthdate', BirthdayType::class)
            ->add('email')
            ->add('password')
            ->add('roles', ChoiceType::class, 
            [
                'choices' => [
                    // label / transfered value
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN',
                ],
                // multiple choice
                'multiple' => true,
                // checkboxes
                'expanded' => true,
            ])
        ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) 
        {
            // Here we stock all form datas in the $form object
            // from $event (this allows us to use them))
            $form = $event->getForm();
            // get mapped user in the form, from event
            $user = $event->getData();
            // check if user exists
            if ($user->getId() !== null) {
                // if user exist -> edit
                $form->add('email', EmailType::class, 
                [
                    'label' => 'E-mail',
                    // if user's email is null at edit
                    // email is empty string so Validator continues
                    'empty_data' => '',
                ])
                ->add('roles', ChoiceType::class, 
                [
                    'label' => 'Rôles',
                    'choices' => [
                        // label / transfered value
                        'Utilisateur' => 'ROLE_USER',
                        'Administrateur' => 'ROLE_ADMIN',
                    ],
                    // multiple choices
                    'multiple' => true,
                    // checkboxes
                    'expanded' => true,
                ])
                ->add('password', null, [
                    'label' => 'Nouveau mot de passe',
                    // the form is no longer manage this property, it's just a field not linked to the entity
                    'mapped' => false,
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
