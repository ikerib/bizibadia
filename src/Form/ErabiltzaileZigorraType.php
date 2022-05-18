<?php

namespace App\Form;

use App\Entity\ErabiltzaileZigorra;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ErabiltzaileZigorraType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateStart')
            ->add('dateEnd')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('erabiltzailea')
            ->add('zigorra')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ErabiltzaileZigorra::class,
        ]);
    }
}
