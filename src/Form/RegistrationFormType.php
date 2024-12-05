<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, options: [
                'label' => 'Email',
                'label_attr' => ['class' => 'text1 mx-5'],
                'required' => true,
                'attr' => ['class' => 'form-control mx-5', 'placeholder' => 'Enter email']
            ])
            ->add('first_name', TextType::class, options: [
                'label' => 'First name',
                'label_attr' => ['class' => 'text1 mx-5'],
                'required' => true,
                'attr' => ['class' => 'form-control mx-5', 'placeholder' => 'Enter first name']
            ])
            ->add('last_name', TextType::class, options: [
                'label' => 'Last name',
                'label_attr' => ['class' => 'text1 mx-5'],
                'required' => true,
                'attr' => ['class' => 'form-control mx-5', 'placeholder' => 'Enter last name']
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => 'Password',
                'label_attr' => ['class' => 'text1 mx-5'],
                'mapped' => false,
                'attr' => ['class' => 'form-control mx-5', 'placeholder' => 'Enter password', 'autocomplete' => 'new password'],
                // 'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'Agree',
                'label_attr' => ['class' => 'text1 mx-5'],
                'mapped' => false,
                'attr' => ['class' => 'checkbox box1'],
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
