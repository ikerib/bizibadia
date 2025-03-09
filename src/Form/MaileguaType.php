<?php

namespace App\Form;

use App\Entity\Gunea;
use App\Entity\Mailegua;
use App\Entity\Zigorra;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('dateEnd', DateTimeType::class, [
                'required' => false,
                'label' => 'Amaierako eguna eta ordua',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => [
                    'class' => 'form-control input-inline datetimepicker w600',
                    'data-provide' => 'datetimepicker',
                ],
            ])
            ->add('udala')
            ->add('erabiltzailea', null, [
                'required' => true,
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
                'required' => true,
                'label' => 'Hasierako gunea',
                'attr' => [
                    'class' => 'w600 select2'
                ]
            ])
            ->add('endGunea', EntityType::class, [
                'required' => false,
                'class' => Gunea::class,
                'label' => 'Non uzten du bizikleta? Zein da amaierako gunea?',
                'placeholder' => 'Aukeratu amaierako gune bat',
                'attr' => [
                    'class' => 'w600 select2'
                ]
            ])
            ->add('zigorra', EntityType::class, [
                'required' => false,
                'class' => Zigorra::class,
                'label' => 'Zigorrik du?',
                'placeholder' => 'Aukeratu'
            ])
            ->add('matxura', CKEditorType::class, [
                'label' => 'Matxurarik dauka bizikletak?',
                'mapped' => false
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
