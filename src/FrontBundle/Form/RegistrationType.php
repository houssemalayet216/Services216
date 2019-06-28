<?php
// src/AppBundle/Form/RegistrationType.php

namespace FrontBundle\Form;
use FrontBundle\Form\StringToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\PropertyAccess\PropertyPath;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use BackBundle\Entity\Service;
class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

       $transformer = new StringToArrayTransformer();
        $builder 


       ->add('roles', ChoiceType::class, array(
    'choices'  => array(
        'Client' => 'ROLE_CLIENT',
        'Agent de service' => 'ROLE_FOURNISSEUR'
       
    ),
      
     'attr' => array('class'=>'form-control show-autre','placeholder'=>'Type Compte','required'=>true ,'property_path' => false),
     'multiple'  => false,
      'placeholder' => 'Type Compte'

     

))

 ->add('raison', null, array('attr'=>array('class'=>'form-control','placeholder'=>'Raison')))


  /*     ->add('raison', ChoiceType::class, array(
    'choices'  => array(
        'particulier' => 'Particulier',
        'Auto entrepreneur' => 'Auto entrepreneur',
        'Entreprise individuelle' => 'Entreprise individuelle',
        'SARL' => 'SARL',
        'SA' => 'SA',
        'Autres' => 'Autres'
       
       
    ),
      
     'attr' => array('class'=>'form-control','placeholder'=>'Raison Sociale','required'=>true ,'property_path' => false),
     'multiple'  => false,
      'placeholder' => 'Raison Sociale'

     

))*/



      ->add('service', EntityType::class, array(
    'class' => 'BackBundle:Service',
    
    'choice_label' => 'titre',
         'attr' => array('class'=>'form-control','placeholder'=>'Secteur','required'=>true ,'property_path' => false),
     'multiple'  => false,
      'placeholder' => 'Secteur'

     

)
)
   


        ->add('pays', ChoiceType::class, array(
    'choices'  => array(
        'Åland Islands'=> 'Åland Islands',
        'Australia' => 'Australia',
        'Austria' => 'Austria',
        'Belgium' => 'Belgium',
         'Brazil' => 'Brazil',
         'Canada'=>'Canada',
         'Croatia'=>'Croatia',
        'Czech Republic'=>'Czech Republic',
        'Denmark'=>'Denmark',
        'British'=>'British',
        'France'=>'France',
        'Germany'=>'Germany',
        'Italy'=>'Italy',
        'Monaco'=>'Monaco',
        'Poland<'=>'Poland<',
        'Portugal'=>'Portugal',
        'Qatar'=>'Qatar',
        'Republic of Ireland'=>'Republic of Ireland',
        'Russia'=>'Russia',
        'Saudi Arabia'=>'Saudi Arabia',
        'Spain'=>'Spain',
        'Switzerland'=>'Switzerland',
        'Sweden'=>'Sweden',
        'United Kingdom'=>'United Kingdom'
        
       
       
    ),
      
     'attr' => array('required'=>true ,'property_path' => false),
     'multiple'  => false,
      'placeholder' => 'pays'

     

))






















 

  ->add('responsable', null, array('attr'=>array('class'=>'form-control','placeholder'=>'Responsable')))
    ->add('telephone', null, array('attr'=>array('class'=>'form-control','placeholder'=>'Telephone')))
    ->add('nom', null, array('attr'=>array('class'=>'form-control','placeholder'=>'Nom')))
    ->add('prenom', null, array('attr'=>array('class'=>'form-control','placeholder'=>'Prenom')))
   ->add('adresse', null, array('attr'=>array('class'=>'form-control','placeholder'=>'Adresse')))
    ->add('cp', null, array('attr'=>array('class'=>'form-control','placeholder'=>'Cp')))
  ->add('tva', null, array('attr'=>array('class'=>'form-control','placeholder'=>'Code tva')) )
   ->add('ncompte', null, array('attr'=>array('class'=>'form-control','placeholder'=>'Numéro du compte bancaire')) )
->add('file', FileType::class, array('label' => 'Document Entreprise'));














       



      $builder ->get('roles')->addModelTransformer(new CallbackTransformer(
                function ($array) {
                    // transform the array to a string
                    return $array[0];
                },
             function ($string)
             {
               return array($string);

             }



            ));
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
}