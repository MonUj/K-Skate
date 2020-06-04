<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('firstName', TextType::class)
            ->add('email', TextType::class, array( 'disabled' => true))
            ->add('address', TextType::class)
            ->add('city', TextType::class)
            ->add('phoneNumber', TextType::class)
            ->add('avatar', FileType::class, [
                'data_class' => null,
                'required'=>null,
                'attr' => array('placeholder' => 'Sélectionner un avatar !')
            ])
            ->add('submit', SubmitType::class, ['label'=>'Sauvegarder', 'attr'=>['class'=>'btn-outline-secondary']])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}