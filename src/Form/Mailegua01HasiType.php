<?php

namespace App\Form;

use App\Entity\Bizikleta;
use App\Entity\Eguraldia;
use App\Entity\Gunea;
use App\Entity\Ibilbidea;
use App\Entity\Mailegua;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Mailegua01HasiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];
        $builder
            ->add('startGunea', EntityType::class, [
                'class' => Gunea::class,
                'label' => 'Hasierako gunea',
                'placeholder' => 'Aukeratu hasierako gune bat',
                'attr' => [
                    'class' => 'w600 select2'
                ]
            ])
            ->add('bizikleta', EntityType::class, [
                'class' => Bizikleta::class,
                'query_builder' => function (EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('b')
                        ->innerJoin('b.udala', 'udala')
                        ->andWhere('udala.id=:udalaid')->setParameter('udalaid', $user->getUdala()->getId())
                        ->orderBy('b.code', 'ASC');
                },
                'placeholder' => 'Aukeratu alokatuko duen bizikleta',
                'label' => 'Bizikleta',
                'attr' => [
                    'class' => 'w600 select2'
                ]
            ])
            ->add('dateStart', DateTimeType::class, [
                'required' => true,
                'label' => 'Hasierako eguna eta ordua',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => [
                    'class' => 'form-control input-inline datetimepicker w600',
                    'data-provide' => 'datetimepicker',
                ],
            ])
            ->add('ibilbidea', EntityType::class, [
                'class' => Ibilbidea::class,
                'label' => 'Ibilbide estimatua',
                'placeholder' => 'Aukeratu ibilbidea',
                'attr' => [
                    'class' => 'w600 select2'
                ]
            ])
            ->add('eguraldia', EntityType::class, [
                'class' => Eguraldia::class,
                'label' => 'Zer eguraldi egiten du?',
                'placeholder' => 'Aukeratu bat',
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
            'user' => null
        ]);
    }
}
