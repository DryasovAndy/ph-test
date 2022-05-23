<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->setMethod('GET');
        $builder
            ->add(
                'code',
                TextType::class,
                [
                    'label' => 'Code:',
                    'required' => false,
                ]
            )
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Name:',
                    'required' => false,
                ]
            )
            ->add('search', SubmitType::class, ['label' => 'Search']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
//        $resolver->setDefaults(['data_class' => LocationsCountries::class]);
    }
}