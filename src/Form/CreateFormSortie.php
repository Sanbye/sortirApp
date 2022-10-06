<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateFormSortie extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class, ['label' => 'Nom de la sortie : '])
            ->add('dateHeureDebut', DateTimeType::class, ['html5' => true,
                'widget' => 'single_text',
                'label' => 'Entre : ',
                'required'=>false])
            ->add('dateLimiteInscription', DateType::class, [ 'html5' => true,
                'widget' => 'single_text',
                'label' => 'et ',
                'required'=>false])
            ->add('nbInscriptionsMax',IntegerType::class, ['label' => 'Nombre de places : '])
            ->add('duree',IntegerType::class, ['label' => 'Durée : '])
            ->add('infosSortie',TextareaType::class, ['label' => 'Description et infos : '])
            ->add('Lieu', EntityType::class, [
                'class' => Lieu::class,
                'label' => 'Lieu : ',
                'choice_label' => function ($lieu) {
                    return $lieu->getNom();
                },
                ])
            ->add('enregistrer', SubmitType::class, ['label' => 'Enregistrer'])
            ->add('publier', SubmitType::class, ['label' => 'Publier la sortie'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}