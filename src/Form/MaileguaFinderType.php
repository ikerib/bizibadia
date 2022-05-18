<?php

namespace App\Form;

use App\Entity\Mailegua;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaileguaFinderType extends AbstractType
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
            ->add('erabiltzailea')
            ->add('bizikleta')
            ->add('startGunea')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mailegua::class,
        ]);
    }
}
