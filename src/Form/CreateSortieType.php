<?php

namespace App\Form;

<<<<<<< HEAD
use App\Entity\Campus;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
=======
use App\Entity\Sortie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
>>>>>>> 19aac85ee9af1889515d52dbd5a24783ead46d9b
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
<<<<<<< HEAD
            ->add('dateHeureDebut', DateType::class, ['label' => 'Date et heure de la sortie : '])
            ->add('dateLimiteInscription', DateType::class, ['label' => 'Date limite d\'inscription : '])
            ->add('nbInscriptionsMax', NumberType::class, ['label' => 'Nombre de places : '])
            ->add('duree', TimeType::class, ['label' => 'Durée'])
            ->add('infosSortie', TextareaType::class, ['label' => 'Description et infos : '])
            ->add('campus', EntityType::class, ['class' => Campus::class, 'choice_label' => 'nom'])
            ->add('lieu', TextType::class)
=======
            ->add('dateHeureDebut', DateType::class, ['label' => 'Date et heure de la sortie'])
            ->add('dateLimiteInscription', DateType::class, ['label' => 'Date limite d\'inscription'])
            ->add('duree', TimeType::class)
            ->add('nbInscriptionsMax', NumberType::class)
            ->add('infosSortie', TextareaType::class)
            ->add('lieu', TextType::class)
            ->add('etat', ChoiceType::class)
>>>>>>> 19aac85ee9af1889515d52dbd5a24783ead46d9b
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
