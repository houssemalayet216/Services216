<?php


namespace BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use BackBundle\Entity\Membre;

class MembreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      
          $builder
             


              ->add('civilite', ChoiceType::class, array(
    'choices'  => array(
        'Père'=> 'Père',
        'Mère' => 'Mère',
         'Frère' => 'Frère',
         'Soeur'=>'Soeur',
         'Autre'=>'Autre'
        
        
       
       
    ),
      
     'attr' => array('required'=>true ,'property_path' => false),
     'multiple'  => false,
      'placeholder' => 'civilité'

     

))

            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)



          ->add('datenaissance', DateType::class ,[
                  'widget' => 'single_text',
                'html5' => false,

    // adds a class that can be selected in JavaScript
    'attr' => ['class' => 'js-datemembre'],])

      ->add('relation', ChoiceType::class, array(
    'choices'  => array(
        'Père'=> 'Père',
        'Mère' => 'Mère',
         'Frère' => 'Frère',
         'Soeur'=>'Soeur',
         'Autre'=>'Autre'
        
        
       
       
    ),
      
     'attr' => array('required'=>true ,'property_path' => false),
     'multiple'  => false,
      'placeholder' => 'Type Visite'

     

))


        ->add('ville', ChoiceType::class, array(
    'choices'  => array(
        'Ariana'=> 'Ariana',
        'Tunis' => 'Tunis',
        'Béja' => 'Béja',
        'Bizert' => 'Bizert',
         'Gabes' => 'Gabes',
         'Ben Arous'=>'Ben Arous',
         'Gafsa'=>'Gafsa',
        'Jendouba'=>'Jendouba',
        'Kairouan'=>'Kairouan',
        'Kasserine'=>'Kasserine',
        'Kébeli'=>'Kébeli',
        'Kef'=>'Kef',
        'Mahdia'=>'Mahdia',
        'Manouba'=>'Manouba',
        'Médnine'=>'Médnine',
        'Nabeul'=>'Nabeul',
        'Sfax'=>'Sfax',
        'Sidi Bouzid'=>'Médnine',
        'Siliana'=>'Siliana',
        'Sousse'=>'Sousse',
        'Tataouine'=>'Tataouine',
        'Touzeur'=>'Touzeur',
        'Zaghouan'=>'Zaghouan'
        
       
       
    ),
      
     'attr' => array('required'=>true ,'property_path' => false),
     'multiple'  => false,
      'placeholder' => 'ville'

     

))


              ->add('adresse', TextType::class)
            ->add('cp', TextType::class)


      ->add('telephone', TextType::class)
      ->add('telephoneII', TextType::class)
       ->add('fix', TextType::class);
         







        
    }


    public function configureOptions(OptionsResolver $resolver)
{
    $resolver->setDefaults([
        'data_class' => null,
    ]);
}


}