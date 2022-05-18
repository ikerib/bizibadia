<?php

namespace App\Form;

use App\Entity\Mailegua;
use App\Entity\Zigorra;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaileguaZigorraType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('zigorra', EntityType::class, [
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
