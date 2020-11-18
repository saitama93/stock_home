<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, $this->getConfiguration("Pseudo", "Entrez le pseudo"))
            ->add('firstName', TextType::class, $this->getConfiguration("Prénom", "Entrez le prénom"))
            ->add('lastName', TextType::class, $this->getConfiguration("Nom", "Entrez le Nom"))
            ->add('email', EmailType::class, $this->getConfiguration("Email", "Entrez l'email"))
            ->add('present', ChoiceType::class, $this->getConfiguration("Statut compte", "", [
                'choices' => [
                    'Activer' => true,
                    'Désactiver' => false
                ]
            ]));
            // ->add('password',RepeatedType::class,[
            //     'type'=> PasswordType::class,
            //     'invalid_message' => 'Les deux mots de passe doivent correspondrent',
            //     'required' => true,
            //     'first_options' => ['label' => 'Mot de passe'],
            //     'second_options' => ['label' => 'Confirmer le mot de passe'],
            // ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
