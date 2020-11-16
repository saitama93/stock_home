<?php

namespace App\Form;

use App\Entity\Mark;
use App\Entity\Type;
use App\Entity\User;
use App\Entity\Status;
use App\Entity\Location;
use App\Entity\Equipment;
use App\Entity\Specificity;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UpdateEquipmentType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('serialNumber', TextType::class, $this->getConfiguration('Numéro de série', 'Saisir/Scanner le numéro de série'))
            ->add('keywords', TextType::class, $this->getConfiguration('Mot(s) clé(s)', 'Saisir le(s) mot(s) clé(s)'))
            ->add('manipulatedAt',  DateType::class,$this->getConfiguration('Date de dernière modification','',[
                'widget' => 'single_text'
            ]))
            ->add('deleted')
            ->add('user', EntityType::class, $this->getConfiguration("Dernier intervenant", "",[
                'class' => User::class,
                'choice_label' =>'getFullName',
                'required' => false
            ]))
            ->add('mark', EntityType::class, $this->getConfiguration("Marque", "Marque du matériel",[
                'class' => Mark::class,
                'choice_label' => 'getWording',
                'required' => false
            ]))
            ->add('type', EntityType::class, $this->getConfiguration("Type", "Type du matériel",[
                'class' => Type::class,
                'choice_label' => 'getWording',
                'required' => false
            ]))
            ->add('specificity', EntityType::class, $this->getConfiguration("Spécificité", "Spécificité du matériel",[
                'class' => Specificity::class,
                'choice_label' => 'getWording',
                'required' => false
            ]))
            ->add('location', EntityType::class, $this->getConfiguration("Site", "Site actuel du matériel",[
                'class' => Location::class,
                'choice_label' => 'getWording',
                'required' => false
            ]))
            ->add('status', EntityType::class, $this->getConfiguration("Statut", "Statut du matériel",[
                'class' => Status::class,
                'choice_label' => 'getWording',
                'required' => false
            ]))
            ->add('deleted', ChoiceType::class, $this->getConfiguration("Mise en stock", "", [
                'choices' => [
                    'Mettre en stock' => false,
                    'Ne pas mettre en stock' => true
                ]
            ]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Equipment::class,
        ]);
    }
}
