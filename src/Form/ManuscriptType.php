<?php

namespace App\Form;

use App\Entity\Manuscript;
use App\Entity\Author;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ManuscriptType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('type', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('cover', TextType::class, [
                'label' => 'Image de couverture'
            ])
            ->add('author', EntityType::class, 
            [
                'class' => Author::class,
                'choice_label' => 'pen_name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Manuscript::class,
        ]);
    }
}
