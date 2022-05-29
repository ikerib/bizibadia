<?php

namespace App\Form;

use App\Entity\Gunea;
use App\Entity\Mailegua;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Mailegua02FinderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateStart', DateTimeType::class, [
                'required' => false,
                'label' => 'Hasierako eguna eta ordua',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => [
                    'class' => 'form-control datetimepicker-date-only w600',
                    'data-provide' => 'datetimepicker',
                ],
            ])
            ->add('erabiltzailea', TextType::class,[
                'label' => 'Erabiltzailea',
                'required' => false,
                'mapped' => false,
                'attr' => ['autocomplete' => 'off']
            ])
            ->add('bizikleta')
            ->add('startGunea', EntityType::class, [
                'class' => Gunea::class,
                'label' => 'Hasierako gunea',
                'placeholder' => 'Aukeratu bat',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mailegua::class,
        ]);
    }
}
