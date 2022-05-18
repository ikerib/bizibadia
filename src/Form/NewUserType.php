<?php

namespace App\Form;

use App\Entity\Udala;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class NewUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'form.user.name',
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 3
                    ])
                ]
            ])
            ->add('surname', null, [
                'label' => 'form.user.surname',
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 3
                    ])
                ]
            ])
            ->add('email', null, [
                'label' => 'form.user.email',
                'constraints' => [
                    new NotBlank(),
                    new Email()
                ]
            ])
            ->add('language', ChoiceType::class,[
                'label' => 'form.user.language',
                'choices' => [
                    'Euskera' => 'eu',
                    'Gaztelera' => 'es'
                ]
            ])
            ->add('username', null, [
                'label' => 'form.user.username',
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 3
                    ])
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'form.user.password-not-same',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options' => ['label' => 'form.user.password'],
                'second_options' => ['label' => 'form.user.password-repeat'],
                'attr' => ['autocomplete' => 'off'],
            ])
            ->add('roles', ChoiceType::class, [
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices'  => [
                    'Administraria' => 'ROLE_ADMIN',
                    'Kudeatzailea' => 'ROLE_KUDEATU',
                ],
            ])

            ->add('udala', EntityType::class, [
                'class' => Udala::class,
                'label' => 'form.user.udala',
                'placeholder' => 'form.user.aukeratu',
                'constraints' => [
                    new NotBlank()
    ]
            ])
        ;

        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    // transform the array to a string
                    return count($rolesArray)? $rolesArray[0]: null;
                },
                function ($rolesString) {
                    // transform the string back to an array
                    return [$rolesString];
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
