<?php

namespace App\Form;

use App\Entity\Zigorra;
use Doctrine\DBAL\Types\FloatType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ZigorraType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Izena',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('udala')
            ->add('deskribapena', CKEditorType::class,[
                'label' => 'Deskribapena',
                'required' => false
            ])
            ->add('egunak', null, [
                'label' => 'Egunak',
                'required' => false
            ])
            ->add('zenbatekoa', NumberType::class, [
                'label' => 'Zenbatekoa',
                'required' => false
            ])
            ->add('canRent', null, [
                'label' => 'Alokatu ahal du',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Zigorra::class,
        ]);
    }
}
