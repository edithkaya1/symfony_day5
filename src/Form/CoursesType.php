<?php

namespace App\Form;

use App\Entity\Courses;
use App\Entity\Status;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CoursesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, options: [
                'label' => 'Course name',
                'label_attr' => ['class' => 'text1 mx-5'],
                'required' => true,
                'attr' => ['class' => 'form-control mx-5', 'placeholder' => 'Enter course name']
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Puppy course' => 'PUPPY',
                    'Activity course' => 'ACTIVITY',
                    'Everyday course' => 'EVERYDAY',
                    'Individual course' => 'INDIVIDUAL',
                    'Senior course' => 'SENIOR',
                ],
                'attr' => ['class' => 'form-control box mx-5'],
                'label' => 'Courses type',
                'label_attr' => ['class' => 'text1 mx-5'],
            ])

            ->add('price', NumberType::class, options: [
                'html5' => true,
                'label' => 'Course price',
                'label_attr' => ['class' => 'text1 mx-5'],
                'attr' => ['class' => 'form-control mx-5', 'min' => '0', 'scale' => '2' ,'placeholder' => 'Enter price']
            ])

            ->add('picture', FileType::class, [
                'label' => 'Course picture (png, jpg, jpeg files)',
                'label_attr' => ['class' => 'text1 mx-5'],
                'attr' => ['class' => 'form-control mx-5'],
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
                // unmapped fields can't define their validation using attributes
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '4048k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image document',
                    ])
                ],
            ])
            ->add('description', TextareaType::class, options: [
                'label' => 'Course description',
                'label_attr' => ['class' => 'text1 mx-5'],
                'attr' => ['class' => 'form-control mx-5 box', 'placeholder' => 'Enter description']
            ])
            ->add('no_units', NumberType::class, options: [
                'html5' => true,
                'label' => 'Course units',
                'label_attr' => ['class' => 'text1 mx-5'],
                'attr' => ['class' => 'form-control mx-5', 'min' => '0', 'placeholder' => 'Enter number of units']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Courses::class,
        ]);
    }
}
