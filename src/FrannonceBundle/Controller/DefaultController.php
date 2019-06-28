<?php

namespace FrannonceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use BackBundle\Entity\Notification;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use BackBundle\Entity\Annonce;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\JsonResponse;
use BackBundle\Entity\Service;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use BackBundle\Entity\Membre;
use BackBundle\Entity\Dates;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class DefaultController extends Controller
{
   

 /**
     * @Route("/user/home/deposer-annonce" , name="deposer_annonce")
     */
    public function homeAction(Request $request)
    {
       $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $authchecker= $this->container->get('security.authorization_checker');
     
        $entityManager=$this->getDoctrine()->getManager();


    if((is_object($user) || $user instanceof UserInterface))
        {


         if($authchecker->isGranted('ROLE_FOURNISSEUR'))
         {

              $service=$user->getService();
   

                   $annance = new Annonce();

    $form = $this->createFormBuilder($annance)
        ->add('titre', TextType::class)
         ->add('description', TextareaType::class)
                 ->add('zone', ChoiceType::class, array(
    'choices'  => array(
        'tunis'=> 'tunis',
        'Béja' => 'Béja',
        'Bizert' => 'Bizert',
         'Gabes' => 'Gabes',
         'Gafsa'=>'Gafsa',
        'Jendouba'=>'Jendouba',
        'Kairouan'=>'Kairouan',
        'Kasserine'=>'Kasserine',
        'Kébeli'=>'Kébeli',
        'Kef'=>'Kef',
        'Mahdia'=>'Mahdia',
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




      ->add('typetarif', ChoiceType::class, array(
    'choices'  => array(
        'Par jour'=> 'par jour',
        'Par heure' => 'Par heure',
        'Par service'=> 'Par service'
    
        
        
       
       
    ),
      
     'attr' => array('required'=>true ,'property_path' => false),
     'multiple'  => false,
      'placeholder' => 'Type de tarification'

     

))


       ->add('devis', ChoiceType::class, array(
    'choices'  => array(
        'Euro'=> 'eur',
        'USD' => 'usd',
      
    
        
        
       
       
    ),
      
     'attr' => array('required'=>true ,'property_path' => false),
     'multiple'  => false,
      'placeholder' => 'Devis'

     

))
          

          ->add('secteur', TextType::class)
          
         // ->add('prix',TextType::class)
  

          
             ->add('autres', TextareaType::class)
          
               ->add('image', FileType::class)



        
        ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted()) {

       if  ($form->isValid())
         {

       if($form['image']->getData() != null)
       {
          $file =$form['image']->getData();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('logo_directory'),
                $fileName
            );

         $annance->setImage($fileName);




     }

     

   $nbrcompetence=$request->request->get('nbrcompetence');

 $cordonnees=$request->request->get('affichercord-offre');

 if(''!== $cordonnees && null !== $cordonnees)
{
    $annance->setCordaffiche(true);

    }else{
       
       $annance->setCordaffiche(false);
    }
if($nbrcompetence>0)
 {
  
    for($i=1;$i<=$nbrcompetence;$i++)
    {
        $competence=$request->request->get('competence_'.$i);
            if('' !== $competence && null !== $competence)
             {
               
               $comp=$entityManager->getRepository('BackBundle:Mission')->find($competence);

                $annance->addMission($comp);
             }    

    }
 }




 $option=$request->request->get('option-offre');
 



         $options = $entityManager->getRepository('BackBundle:Options')->findOneBy(
array('titre'=>$option,'service'=>$service) 
);
                 // $ser = $entityManager->getRepository('BackBundle:Service')->find($service);

         $tarif=$request->request->get('prix-offre');

     $annance->setUser($user);

     $annance->setService($service);
     $annance->setSpecialite($options);
     $annance->setOption($option);
     $annance->setPrix($tarif);
     $annance->setDatePublication(new \DateTime());
     $annance->setTypeAnnance('offre');
     $annance->setPublier(true);
     $annance->setSecteur($user->getService()->getTitre());


      $entityManager->persist($annance);


      $entityManager->flush();



     

      if($request->isXmlHttpRequest())
                     {

                        $msg='Ajouter annonce avec succèss ! ';
                        $response=new JsonResponse(array('success'=>true,'message'=>$msg));

                     }


}

     else{

        if($request->isXmlHttpRequest())
             {

                $formErrors=$this->get('validator')->validate($form);
                $errorsArray=[];

                foreach ($formErrors  as $error) {
                    
                    $errorsArray[]=array(
                       'elementId'=>$error->getPropertyPath(),
                       'errorMessage'=>$error->getMessage(),

                      
                    );

                }

                $msg="vouillez rensigner tous les champs";
                $response=new JsonResponse(['success'=>false,'message'=>$msg,'errors'=>$errorsArray]);
             }

          }




      return $response;
    


    }
       


$options = $entityManager->getRepository('BackBundle:Options')->findBy(
array('service'=>$service) 
);

   


    







































     $valid=$user->getValid();
         
         return $this->render('FrannonceBundle:Agent:addoffre.html.twig',[
        'form' => $form->createView(),'user'=>$user,'option'=>$options,'valid'=>$valid]);



         }elseif($authchecker->isGranted('ROLE_CLIENT')){




      

                $annance = new Annonce();

    $form = $this->createFormBuilder($annance)
        ->add('titre', TextType::class)
         ->add('description', TextareaType::class)
         
      ->add('service', EntityType::class, array(
    'class' => 'BackBundle:Service',
    
    'choice_label' => 'titre',
         'attr' => array('placeholder'=>'choisir une service','required'=>true ,'property_path' => false),
     'multiple'  => false,
     'placeholder'=>'choisir une service'
     

))

/*
      ->add('jours', EntityType::class, array(
    'class' => 'BackBundle:Jour',
    
    'choice_label' => 'jour',
         'attr' => array('class'=>'form-control','placeholder'=>'Jour','required'=>true ,'property_path' => false),
     'multiple'  => true,
      'placeholder' => 'Jour'

))
*/
/*
 ->add('dateVisite', TimeType::class ,[
                  'widget' => 'single_text',
                'html5' => false,

    // adds a class that can be selected in JavaScript
    'attr' => ['class' => 'js_datedemande'],])*/




 ->add('datePrevu', TimeType::class ,[
                  'widget' => 'single_text',
                'html5' => false,

    // adds a class that can be selected in JavaScript
    'attr' => ['class' => 'js_timedemande'],])




  ->add('typeVisite', ChoiceType::class, array(
    'choices'  => array(
        'Une seule visite'=> 'Une',
        'Plusieurs Visites' => 'Plusieurs'
        
        
        
       
       
    ),
      
     'attr' => array('required'=>true ,'property_path' => false),
     'multiple'  => false,
      'placeholder' => 'Type Visite'

     

))

 

      
    
  
     



      ->add('membres', EntityType::class, array(
    'class' => 'BackBundle:Membre',
    'query_builder' => function (EntityRepository  $tr) {
        $user=$this->container->get('security.token_storage')->getToken()->getUser();
        return $tr->createQueryBuilder('m')
        ->where('m.user = :user')
->setParameter('user', $user);

          
    },
    'choice_label' => 'nom',
    'attr' => array('data-rule-required'=>'true'),
    'multiple'  => true
))    

         
          
     
          


   

       

          
             ->add('autres', TextareaType::class)
             
            /* ->add('civilite',MembreType::class)
               ->add('nom',MembreType::class)
                 ->add('prenom',MembreType::class)
                   ->add('datenaissance',MembreType::class)
                     ->add('relation',MembreType::class)
                     ->add('ville',MembreType::class)
                     ->add('adresse',MembreType::class)
                     ->add('cp',MembreType::class)
                      ->add('telephone',MembreType::class)
                      ->add('telephoneII',MembreType::class)
                      ->add('fix',MembreType::class)
*/
        
        ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted()) {

       if  ($form->isValid())
         {

  $nbrcompetence=$request->request->get('nbrcompetence');


/*$nbrvisite=$request->request->get('number_visite_demande');
$nbsemaine=$request->request->get('number_semaine_demande');

 $nbrpersonne=$request->request->get('number_personne_demande');*/
  $telephone=$request->request->get('telephone_demande');
  $telephoneII=$request->request->get('telephone2_demande');
  $fix=$request->request->get('fix_demande');
  $email=$request->request->get('email_demande');
  $ville=$request->request->get('ville_demande');
  $adresse=$request->request->get('adresse_demande');
  $cp=$request->request->get('cp_demande');
/*  $tarif=$request->request->get('totale_demande_submited');*/
$option=$request->request->get('option_demande');
if(''!== $option && null !== $option)
{
 $OPT = $entityManager->getRepository('BackBundle:Options')->find($option);
 $annance->setSpecialite($OPT);
}
 $dates=$request->request->get('datedemande');
$tab = explode(",", $dates);

foreach ($tab as $date) {
$datesvistes=new Dates();
$newDate = \DateTime::createFromFormat('d/m/Y',$date) ;
$datesvistes->setDatev($newDate);
 $entityManager->persist($datesvistes);


      $entityManager->flush();



$annance->addDate($datesvistes);
}


 

 


$fourniture=$request->request->get('fourniture-demande');
$aporter=$request->request->get('aporter-demande');
$cordonnees=$request->request->get('affichercord-demande');

$depart=$request->request->get('depart');
$arriver=$request->request->get('arrive');
$listeproduits=$request->request->get('listeproduits');
$membresadress=$request->request->get('currentadresse');
$trajet=$request->request->get('trajet');



 if(''!== $listeproduits && null !== $listeproduits)
{
   
  $annance->setProduits($listeproduits); 

}

 if(''!== $depart && null !== $depart)
{
   
  $annance->setDepart($depart); 

}

 if(''!== $arriver && null !== $arriver)
{
   
  $annance->setArrive($arriver); 

}





 if(''!== $membresadress && null !== $membresadress)
{
    $annance->setAdressmembre(true);

    }else{
       
       $annance->setAdressmembre(false);
    }


 if(''!== $trajet && null !== $trajet)
{
     if($trajet=='allezretour')
     {
       $annance->setTrajet(true);
     }else{
       $annance->setTrajet(false);
     }
   

    }







 if(''!== $cordonnees && null !== $cordonnees)
{
    $annance->setCordaffiche(true);

    }else{
       
       $annance->setCordaffiche(false);
    }

     if(''!== $fourniture && null !== $fourniture)
{
    $annance->setAchat(true);

    }else{
       
       $annance->setAchat(false);
    }





     if(''!== $aporter && null !== $aporter)
{
    $annance->setAport(true);

    }else{
       
       $annance->setAport(false);
    }



  if($nbrcompetence>0)
 {
  
    for($i=1;$i<=$nbrcompetence;$i++)
    {
        $competence=$request->request->get('competence_'.$i);


            if('' !== $competence && null !== $competence)
             {
               
               $comp=$entityManager->getRepository('BackBundle:Mission')->find($competence);

                $annance->addMission($comp);
             }    

    }
 }







$annance->setVille($ville);
$annance->setAdresse($adresse);  
$annance->setCp($cp); 


$annance->setTelephone($telephone);
$annance->setFix($fix);
$annance->setEmail($email);
/*$annance->setNbrsemaine($nbsemaine);*/
$annance->setTelephoneII($telephoneII);
/*$annance->setNbrIntervention($nbrvisite);
$annance->setNbrmembres($nbrpersonne);*/


        $annance->setUser($user);
     $annance->setDatePublication(new \DateTime());
     $annance->setTypeAnnance('demande');
     $annance->setPublier(true);




 $entityManager->persist($annance);


      $entityManager->flush();

     

      if($request->isXmlHttpRequest())
                     {

                        $msg=' Annonce  Ajouter avec succèss ! ';
                        $response=new JsonResponse(array('success'=>true,'message'=>$msg));

                     }


}

     else{

        if($request->isXmlHttpRequest())
             {

                $formErrors=$this->get('validator')->validate($form);
                $errorsArray=[];

                foreach ($formErrors  as $error) {
                    
                    $errorsArray[]=array(
                       'elementId'=>$error->getPropertyPath(),
                       'errorMessage'=>$error->getMessage(),

                      
                    );

                }

                $msg="vouillez rensigner tous les champs";
                $response=new JsonResponse(['success'=>false,'message'=>$msg,'errors'=>$errorsArray]);
             }

          }




      return $response;
    


    }
       
  
$members=$entityManager->getRepository('BackBundle:Membre')->findBy(array('user'=>$user));

$nbrmembre=count($members);




    return $this->render('FrannonceBundle:Client:adddemande.html.twig', [
        'form' => $form->createView(),'nbrmembre'=>$nbrmembre
    ]); 












         }else{
              

         	   $this->get('session')->getFlashBag()->add('noticeErreur','Eureur');
        // return $this->redirect( $this->generateUrl('fos_user_security_login'));
          
          return $this->redirectToRoute('fos_user_security_login');

         }











        }else{

              $route=$request->get('_route');
               

              $this->get('session')->set('referer',$route);

          $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));

        }

}





}
