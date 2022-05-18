<?php

namespace App\Form;

use App\Entity\Mailegua;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaileguaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateStart', DateTimeType::class, [
                'required' => true,
                'label' => 'Hasiera data',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => [
                    'class' => 'form-control input-inline datetimepicker w600',
                    'data-provide' => 'datetimepicker',
                ],
            ] )
            ->add('dateEnd')
            ->add('udala')
            ->add('erabiltzailea', null, [
                'label' => 'Erabiltzailea',
                'attr' => [
                    'class' => 'w600 select2'
                ]
            ])
            ->add('bizikleta', null, [
                'label' => 'Bizikleta',
                'attr' => [
                    'class' => 'w600 select2'
                ]
            ])
            ->add('eguraldia', null, [
                'label' => 'Eguraldia',
                'attr' => [
                    'class' => 'w600 select2'
                ]
            ])
            ->add('ibilbidea', null, [
                'label' => 'Ibilbide estimatua',
                'attr' => [
                    'class' => 'w600 select2'
                ]
            ])
            ->add('startGunea', null, [
                'label' => 'Hasierako gunea',
                'attr' => [
                    'class' => 'w600 select2'
                ]
            ])
            ->add('endGunea')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mailegua::class,
        ]);
    }
}
