<?php

namespace NNP\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('username', TextType::class, array('label'=>'Identifiant'))
            //->add('plainPassword', PasswordType::class, array('label'=>'Mot de passe'))
            ->add('prenom', TextType::class)
            ->add('nom', TextType::class)
            ->add('pseudo', TextType::class, array('label'=>'Pseudo (Votre nom sur \'NeNdemPlus\' )'))
            ->add('sexe', ChoiceType::class, array(
                'choices' => array(
                    'm' => 'Male',
                    'f' => 'Female'
                ),
                'required'    => false,
                'empty_data'  => null
            ))
            ->add('photo', FileType::class, array('label' => 'Photo de profil','required'=>false, 'data_class'=>null))
            ->add('description', TextareaType::class)
            ->add('save', SubmitType::class, array('label'=>'Enregistrer'));
        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    /*public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NNP\PlatformBundle\Entity\User'
        ));
    }*/
}
