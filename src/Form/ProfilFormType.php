<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProfilFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo',TextType::class, ['label' => 'Pseudo : '])
            ->add('prenom',TextType::class, ['label' => 'Prénom : '])
            ->add('nom',TextType::class, ['label' => 'Nom : '])
            ->add('telephone',TextType::class, ['label' => 'Téléphone : '])
            ->add('email',EmailType::class, ['label' => 'Email : '])
            ->add('motPasse', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'Le mot de passe doit être identique',
            'options' => ['attr' => ['class' => 'password-field']],
            'required' => true,
            'first_options'  => ['label' => 'Mot de passe : '],
            'second_options' => ['label' => 'Confirmation : '],
             ])
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nom'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }

}

