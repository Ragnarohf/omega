<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('FirstName')
            ->add('LastName')
            ->add('email')
            ->add('roles', HiddenType::class, [
                'mapped' => false,
            ])
            ->add('avatar', FileType::class, [
                'multiple' => false,
                'empty_data' => true,
                'invalid_message' => 'Wrong Format',
                'label' => 'Choose Avatar : ',
                'mapped' => false,
                'required' => false
            ]);
        //->add('password');

        //ajout tout les champs que j'ai besoin de modifier
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
