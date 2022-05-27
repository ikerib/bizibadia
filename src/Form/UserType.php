<?php

namespace App\Form;

use App\Entity\Udala;
use App\Entity\User;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use function PHPUnit\Framework\logicalAnd;

class UserType extends AbstractType
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
            ->add('roles', ChoiceType::class, [
                'label' => 'ROL-a',
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices'  => [
                    'Administraria' => 'ROLE_ADMIN',
                    'Kudeatzailea' => 'ROLE_KUDEATU',
                    'Erabiltzailea' => 'ROLE_USER',
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
            ->add('nan', TextType::class, [
                'label' => 'NAN'
            ])
            ->add('mugikorra', TextType::class, [
                'label' => 'Mugikorra'
            ])
            ->add('iraungitze', DateTimeType::class, [
                'required' => true,
                'label' => 'Iraungitze data',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => [
                    'class' => 'form-control input-inline datetimepicker w600',
                    'data-provide' => 'datetimepicker',
                ],
            ])
            ->add('canRent', CheckboxType::class, [
                'label' => 'Alokatu ahal du?'
            ])
            ->add('bazkidea', CheckboxType::class, [
                'label' => 'Bazkidea da?'
            ])
            ->add('ordainketa', CheckboxType::class, [
                'label' => 'Ordainketa'
            ])
            ->add('pasaitarra', CheckboxType::class, [
                'label' => 'Herritarra?'
            ])
            ->add('sinatuta', CheckboxType::class, [
                'label' => 'Sinatuta'
            ])
            ->add('udallangilea', CheckboxType::class, [
                'label' => 'Udal langilea'
            ])
            ->add('baimenberezia', CheckboxType::class, [
                'label' => 'Baimen berezia'
            ])
            ->add('oharrak', CKEditorType::class,[
                'label' => 'Oharrak'
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
