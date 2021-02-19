<?php

namespace App\Form;

use App\Entity\Aliment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AlimentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'nom',
                TextType::class,
                [
                    'attr' => [
                        'placeholder' => "Tapez le nom de l'aliment...."
                    ]
                ]
            )
            ->add(
                'prix',
                NumberType::class,
                [
                    'attr' => [
                        'placeholder' => "Le prix de votre aliment..."
                    ]
                ]
            )
            // ->add(
            //     'image',
            //     FileType::class,
            //     [
            //         'required' => true
            //     ]
            // )
            ->add('image')
            ->add('calorie')
            ->add('proteine')
            ->add('glucide')
            ->add('lipide');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Aliment::class,
        ]);
    }
}
