<?php

namespace App\Form;

use App\Entity\Mailegua;
use App\Entity\Zigorra;
use Doctrine\ORM\EntityRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Mailegua04ZigorraType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];
        $builder
            ->add('zigorra', EntityType::class, [
                'required' => false,
                'class' => Zigorra::class,
                'query_builder' => function(EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('u')
                        ->innerJoin('u.udala', 'udala')
                        ->andWhere('udala.id=:udalaid')->setParameter('udalaid', $user->getUdala()->getId());
                },
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
            'user' => null
        ]);
    }
}
