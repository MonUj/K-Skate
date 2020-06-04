<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
//use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Category;


class ProductType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('label', TextType::class, ['label' => 'Titre :'])
                ->add('marque', TextType::class, ['label' => 'Marque :'])
                ->add('description', TextareaType::class, ['label' => 'Description de l\'article :'])
                ->add('category', EntityType::class, array(
                    'class' => Category::class,
                    'label' => 'Catégorie :',
                    'choice_label' => 'label', // function ($product) { return $product->getCategory(); }
                ))
                ->add('prix', NumberType::class, ['label' => 'Prix :'])
                ->add('imageFile', FileType::class, ['label' => 'Sélectionner une image :'])
                ->add('submit', SubmitType::class, ['label'=>'Publier', 'attr'=>['class'=>'btn-secondary btn-block']])
        ;
    }
}
?>