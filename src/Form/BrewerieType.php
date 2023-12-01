<?php

namespace App\Form;

use App\Entity\Brewerie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BrewerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'attr' =>[
                'placeholder' => 'Le nom de la brasserie',]
            ])
            ->add('address', TextType::class, [
            'attr' =>[
                'placeholder' => 'Adresse de la brassrie',]
            ])

            ->add('zipcode', TextType::class, [
                'attr' =>[
                      'placeholder' => 'Code postal',]
            ])
            ->add('city', TextType::class, [
                'attr' =>[ 'placeholder' => 'Ville',]
            ])
            
            ->add('state', ChoiceType::class, [
                'label' => 'Choisissez votre région',
                'choices' => [
                    'Votre choix...' => '',
                    'Auvergne-Rhône-Alpes' => 'Auvergne-Rhône-Alpes',
                    'Bourgogne-Franche-Comté' => 'Bourgogne-Franche-Comté',
                    'Bretagne' => 'Bretagne',
                    'Centre-Val-de-Loire' => 'Centre-Val-de-Loire',
                    'Grand-Est' => 'Grand-Est',
                    'Hauts-de-France' => 'Hauts-de-France',
                    'Ile-de-France' => 'Ile-de-France',
                    'Normandie' => 'Normandie',
                    'Nouvelle-Aquitaine' => 'Nouvelle-Aquitaine',
                    'Occitanie' => 'Occitanie',
                    'Pays-de-la-Loire' => 'Pays-de-la-Loire',
                    "Provence-Alpes-Côte-d'Azur" => "Provence-Alpes-Côte-d'Azur",
                ]])

            ->add('website', UrlType::class, [
                'attr' =>[
                    'placeholder' => 'Une URL en http:// ou https://'],
                'label' => 'Site web de la brasserie',
                'default_protocol' => 'https',
                ]);
        
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        // setDefaults is mostly useful if you want to reuse the default values set in parent classes in sub-classes
        $resolver->setDefaults([
            'data_class' => Brewerie::class,
        ]);
    }
}
