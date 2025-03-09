<?php

namespace App\Form;

use App\Entity\Bizikleta;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class BizikletaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', null, [
                'label' => 'Kodea',
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('erregistroa',null, [
                'label' => 'Erregistroa'
            ])
            ->add('bastidorea',null, [
                'label' => 'Bastidorea'
            ])
            ->add('udala')
            ->add('gunea',null, [
                'label' => 'Zein gunetan dago?',
                'required' => true
            ])
            ->add('notes', CKEditorType::class, [
                'label' => 'Oharrak',
            ])
            ->add('desgaituta', null, [
                'label' => 'Hau markatuz gero biziketa hau bajan ematen ta eta ez eskuragarri egongo',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bizikleta::class,
        ]);
    }
}
