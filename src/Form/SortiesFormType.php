<?php

namespace App\Form;

use App\Entity\Campus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;

class SortiesFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
        ->add('campus', EntityType::class, [
        'class' => Campus::class,
        'choice_label' => 'nom',
        'label' => 'Campus : '
            ])
           ->add('search', SearchType::class, ['label' => 'Le nom de la sortie contient : '])
           ->add('dateStart', DateType::class, [  'html5' => true,
               'widget' => 'single_text',
               'label' => 'Entre : '])
           ->add('dateClose', DateType::class, [ 'html5' => true,
               'widget' => 'single_text',
               'label' => 'et '])
           ->add('choiceOrganisateur', CheckboxType::class, [
               'label'    => 'Sorties dont je suis l organisateur/trice'
               ])
           ->add('choiceInscrit', CheckboxType::class, [
               'label'    => 'Sorties auxquelles je suis inscrit/e'
           ])
           ->add('choiceNoInscrit', CheckboxType::class, [
               'label'    => 'Sorties auxquelles je ne suis pas inscrit/e'
           ])
           ->add('choiceEnd', CheckboxType::class, [
               'label'    => 'Sorties passées'
           ])
       ;
    }


}