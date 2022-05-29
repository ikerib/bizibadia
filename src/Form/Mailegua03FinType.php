<?php

namespace App\Form;

use App\Entity\Gunea;
use App\Entity\Mailegua;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Mailegua03FinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateEnd', DateTimeType::class, [
                'required' => true,
                'label' => 'Amaierako eguna eta ordua',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => [
                    'class' => 'form-control input-inline datetimepicker w600',
                    'data-provide' => 'datetimepicker',
                ],
            ])
            ->add('endGunea', EntityType::class, [
                'class' => Gunea::class,
                'label' => 'Non uzten du bizikleta? Zein da amaierako gunea?',
                'placeholder' => 'Aukeratu amaierako gune bat',
                'attr' => [
                    'class' => 'w600 select2'
                ]
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
