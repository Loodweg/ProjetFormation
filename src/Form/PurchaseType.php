<?php

namespace App\Form;

use App\Entity\Purchase;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PurchaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('country',TextType::class,[
                'label' => 'Pays',
                'required' => false
            ])
            ->add('city',TextType::class,[
                'label' => 'Ville',
                'required' => false
            ])
            ->add('street',TextType::class,[
                'label' => 'Rue et numéro',
                'required' => false
            ])
            ->add('postalCode',TextType::class,[
                'label' => 'Code postal',
                'required' => false
            ])
            ->add('telephone',TextType::class,[
                'label' => 'Téléphone',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Purchase::class,
        ]);
    }
}
