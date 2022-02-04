<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'label' => 'Nom du Produit',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ecrire le nom...'
                ]
            ])
            
            ->add('price',MoneyType::class,[
                'label' => 'Prix du produit',
                'required' => false,
                'divisor' => 100
            ])
            
            ->add('imagePath',TextType::class,[
                'label' => 'Image du produit',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ajouter le chemin de l\'image ici'
                ]
            ])
            
            ->add('description',TextType::class,[
                'label' => 'Description du produit',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Une description ?'
                ]
            ])

            ->add('category',EntityType::class,[
                'label' => 'Choisir la catégorie',
                'placeholder' => '-- Choisir --',
                'required' => false,
                'class' => Category::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
