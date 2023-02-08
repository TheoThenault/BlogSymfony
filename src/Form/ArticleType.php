<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => $options['labels_translation']['title']
            ])
            ->add('content', TextareaType::class, [
                'label' => $options['labels_translation']['content'], 'required' => false
            ])
            ->add('author', TextType::class, [
                'label' => $options['labels_translation']['author'], 'required' => false
            ])
            ->add('nbViews', IntegerType::class, [
                'label' => $options['labels_translation']['nbViews'], 'data' => 1, 'attr' => ['min' => 0]
            ])
            ->add('published', CheckboxType::class, [
                'label' => $options['labels_translation']['published'], 'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'labels_translation' => []
        ]);
    }
}
