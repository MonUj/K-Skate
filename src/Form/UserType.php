<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
//use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', TextType::class, ['label' => 'Nom :'])
                ->add('firstName', TextType::class, ['label' => 'Prénom :'])
                ->add('email', EmailType::class, ['label' => 'Email :'])
                ->add('password', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'first_options' => array('label' => 'Mot de passe :'),
                    'second_options' => array('label' => 'Confirmation du mot de passe :'),
                    'invalid_message' => 'Les mots de passe doivent correspondre.',
                ))
                ->add('submit', SubmitType::class, ['label'=>'Envoyer', 'attr'=>['class'=>'btn-secondary btn-block']])
        ;
    }
}
?>
