<?php

namespace App\Form;

use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;


class ImageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('path')
            ->add('name')
            ->add('file', FileType::class, [
                'label' => 'Image',
                'mapped' => false, // Indique que ce champ n'est pas directement lié à une propriété de l'entité
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image.',
                    ])
                ],
            ]);
            //->add('size')
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
