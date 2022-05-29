<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RechercheFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', null, array('required'=>false))
            ->add('prixMin',null, array('required'=>false))
            ->add('prixMax', null, array('required'=>false))
            ->add('categorie', null, array('required'=>false))
//            ->add('minNbFollowers', null, array('required'=>false))
//            ->add('maxNbFollowers', null, array('required'=>false))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
