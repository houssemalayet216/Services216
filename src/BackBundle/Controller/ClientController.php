<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackBundle\Entity\Annonce;
use BackBundle\Entity\Service;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use BackBundle\Form\MembreType;
use BackBundle\Entity\Membre;
use BackBundle\Entity\Dates;
use Symfony\Component\Validator\Constraints\DateTime;

class ClientController extends Controller
{
 

    /**
     * @Route("/user/home/liste-annonces",name="liste_annonces")
     */
    public function annonceclientAction(Request $request)
    {

     $user = $this->container->get('security.token_storage')->getToken()->getUser();
      $entityManager = $this->getDoctrine()->getManager();

     $authchecker= $this->container->get('security.authorization_checker');
     if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
   {
     
       

      
 return $this->render('BackBundle:Client:gestionannonce.html.twig');

     }
   else{
     return $this->redirectToRoute('frontpage');
    
     }



}  






     /**
     * @Route("/user/home/create-annonce",name="create_annonce")
     */
    public function addannonceAction(Request $request)
    {

      $entityManager = $this->getDoctrine()->getManager();

    $user = $this->container->get('security.token_storage')->getToken()->getUser();
  
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
    {
     
          $annance = new Annonce();

    $form = $this->createFormBuilder($annance)
        ->add('titre', TextType::class)
         ->add('description', TextareaType::class)
         
      ->add('service', EntityType::class, array(
    'class' => 'BackBundle:Service',
    
    'choice_label' => 'titre',
         'attr' => array('class'=>'form-control','placeholder'=>'choisir une service','required'=>true ,'property_path' => false),
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
    'attr' => array('data-rule-required'=>'true','class'=>'form-control'),
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




    return $this->render('BackBundle:Client:addannonce.html.twig', [
        'form' => $form->createView(),'nbrmembre'=>$nbrmembre
    ]);  


    }
    else{
       return $this->redirectToRoute('frontpage');
    
    }



}



      /**
     * @Route("/user/home/gestion-membres",name="gestion_membres")
     */
    public function membrelisteAction(Request $request)
    {

     $user = $this->container->get('security.token_storage')->getToken()->getUser();
      $entityManager = $this->getDoctrine()->getManager();

     $authchecker= $this->container->get('security.authorization_checker');
     if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
   {
     
       
   
 return $this->render('BackBundle:Client:gestionmembre.html.twig');

     }
   else{
     return $this->redirectToRoute('frontpage');
    
     }



}
















  /**
     * @Route("/user/home/membres-list",name="membre_famille")
     */
    public function membresAction(Request $request)
    {

     $user = $this->container->get('security.token_storage')->getToken()->getUser();
      $entityManager = $this->getDoctrine()->getManager();

     $authchecker= $this->container->get('security.authorization_checker');
     if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
   {
     
      if($request->isXmlHttpRequest())
                     {
       

      $membres=$entityManager->getRepository('BackBundle:Membre')->findBy(array("user"=>$user),array('id' => 'desc'));
      $output=array('data'=>array());
    
      foreach ($membres as $membre) {
 $id =$membre->getId();         
$nom=$membre->getNom();
$prenom=$membre->getPrenom();
$relation=$membre->getRelation();

$ville=$membre->getVille();
$adresse=$membre->getAdresse();     





$button=' <div  class="text-center">
                 
                    <button class="btn btn-sm  btn-success"  data-toggle="modal" data-target="#myModalmembreedit" onclick="editmembre('.$id.')" ><i class="fa fa-pencil-square-o"></i> Modifier</button> 
                  <button class="btn btn-sm btn-danger"  data-toggle="modal" data-target="#Modalmembredelete" onclick="deletemembre('.$id.')" ><i class="fa fa-trash-o"></i> Supprimer</button></div>';



$output['data'][]=array(


 $nom,
 $prenom,
 $relation,
 $ville,
 $adresse,
 $button


    );




}

 $response=new JsonResponse($output);

/*$response = new \Symfony\Component\HttpFoundation\Response(json_encode($output));
$response->headers->set('Content-Type', 'application/json');
*/return $response;



}else{

   $msg="Erreur requete";
                $response=new JsonResponse(['success'=>false,'message'=>$msg]);

                return $response;

}

}else{

        throw new AccessDeniedException("vous ne pouvez pas accéder a cette ressource !");
    }










}  








    /**
     * @Route("/user/home/delete-member/{id}",name="delete_member")
     */
    public function deletememberAction(Request $request,$id)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
    {
     
       if($request->isXmlHttpRequest())
       {
        $member=$em->getRepository('BackBundle:Membre')->find($id);

       


  
    $em->remove($member);
     $em->flush();
       $msg="Membre supprimer avec success !";
                $response=new JsonResponse(['success'=>true,'message'=>$msg]);

                return $response;

        }else{

              $msg="Erreur requete";
                $response=new JsonResponse(['success'=>false,'message'=>$msg]);

                return $response;

        }
      
       



     }  else{

        throw new AccessDeniedException("vous ne pouvez pas accéder a cette ressource !");
    }



    }







 /**
     * @Route("/user/home/delete-annonce/{id}",name="delete_annonce")
     */
    public function deleteannonceAction(Request $request,$id)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
    {
     
       if($request->isXmlHttpRequest())
       {
        $annonce=$em->getRepository('BackBundle:Annonce')->find($id);

      /*  foreach ($annonce->getDates() as $dates) {    $annonce->removeDate($dates) ;   }

foreach ($annonce->getMembres() as $members) {    $annonce->removeMembre($members)  ;  }

  
    $em->remove($annonce);
     $em->flush();*/

     $annonce->setPublier(false);
     $em->persist($annonce);
     $em->flush();

       $msg="Annonce supprimer avec success !";
                $response=new JsonResponse(['success'=>true,'message'=>$msg]);

                return $response;

        }else{

              $msg="Erreur requete";
                $response=new JsonResponse(['success'=>false,'message'=>$msg]);

                return $response;

        }
      
       



     }  else{

        throw new AccessDeniedException("vous ne pouvez pas accéder a cette ressource !");
    }



    }




















  /**
     * @Route("/user/home/annonce-list",name="annonce_client")
     */
    public function tabannonceAction(Request $request)
    {

     $user = $this->container->get('security.token_storage')->getToken()->getUser();
      $entityManager = $this->getDoctrine()->getManager();

     $authchecker= $this->container->get('security.authorization_checker');
     if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
   {
     
      if($request->isXmlHttpRequest())
                     {
       

      $annonces=$entityManager->getRepository('BackBundle:Annonce')->findBy(array("user"=>$user,"typeAnnance"=>'demande',"publier"=>true),array('id' => 'desc'));
      $output=array('data'=>array());
    
      foreach ($annonces as $annonce) {
 $id =$annonce->getId();         
$titre=$annonce->getTitre();
$service=$annonce->getService()->getTitre();
$option=$annonce->getSpecialite()->getTitre();
$datepublication=$annonce->getDatePublication()->format('Y-m-d');    





$button=' <div  class="text-center">
                 
                    <button class="btn btn-sm  btn-success"  data-toggle="modal" data-target="#myModalannonceedit" onclick="editannonce('.$id.')" ><i class="fa fa-pencil-square-o"></i> Modifier</button> 
                  <button class="btn btn-sm  btn-danger"  data-toggle="modal" data-target="#Modalannoncedelete" onclick="deleteannonce('.$id.')" ><i class="fa fa-trash-o"></i> Supprimer</button></div>';



$output['data'][]=array(


 $titre,
 $service,
 $option,
 $datepublication,
 $button


    );




}

 $response=new JsonResponse($output);

/*$response = new \Symfony\Component\HttpFoundation\Response(json_encode($output));
$response->headers->set('Content-Type', 'application/json');
*/return $response;



}else{

   $msg="Erreur requete";
                $response=new JsonResponse(['success'=>false,'message'=>$msg]);

                return $response;

}

}else{

        throw new AccessDeniedException("vous ne pouvez pas accéder a cette ressource !");
    }










}  






























































 /**
     * @Route("/user/home/create-membre",name="create_membre")
     */
    public function addmembreAction(Request $request)
    {

      $entityManager = $this->getDoctrine()->getManager();

    $user = $this->container->get('security.token_storage')->getToken()->getUser();
    
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
    {
     
          $membre = new Membre();

    $form = $this->createFormBuilder($membre)


        ->add('civilite', ChoiceType::class, array(
    'choices'  => array(
        'Homme'=> 'Homme',
        'Femme' => 'Femme'
        
        
        
       
       
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
      'placeholder' => 'Type Relation'

     

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
       ->add('fix', TextType::class)
          ->add('autres', TextareaType::class)








        
        ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted()) {

       if  ($form->isValid())
         {

 
   


     $membre->setUser($user);


      $entityManager->persist($membre);


      $entityManager->flush();



     

      if($request->isXmlHttpRequest())
                     {

                        $msg='Membre ajouter avec succèss ! ';
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
       



    return $this->render('BackBundle:Client:addmembre.html.twig', [
        'form' => $form->createView()
    ]);  


    }
    else{
       return $this->redirectToRoute('frontpage');
    
    }



}





 /**
     * @Route("/user/home/service-option/{service}",name="service_option")
     */
    public function viewoptionAction(Request $request,$service)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
    {
     




     if($request->isXmlHttpRequest())
       {

       
         $selected = $em->getRepository('BackBundle:Service')->find($service);
         $options=$em->getRepository('BackBundle:Options')->findBy(['service'=>$selected]);
         $output='';
         foreach ($options as $option) {
            $output.='<option value="'.$option->getId().'">'.$option->getTitre().'</option>';
         }
  
           $response=new JsonResponse(['success'=>true,'output'=>$output]);

                return $response;

  
       }else{
           $msg="Erreur requete";
                $response=new JsonResponse(['success'=>false,'message'=>$msg]);

                return $response;

       }
}else{

          throw new AccessDeniedException("vous ne pouvez pas accéder a cette ressource !");
    }

}





   /**
     * @Route("/user/home/demande-tarif/{option}",name="tarif_demande")
     */
    public function demandetarifAction(Request $request,$option)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
    {
     




     if($request->isXmlHttpRequest())
       {

       
         $options = $em->getRepository('BackBundle:Options')->find($option);
         $tarif=$options->getPrix();
           $response=new JsonResponse(['success'=>true,'tarif'=>$tarif]);

                return $response;

  
       }else{
           $msg="Erreur requete";
                $response=new JsonResponse(['success'=>false,'message'=>$msg]);

                return $response;

       }
}else{

          throw new AccessDeniedException("vous ne pouvez pas accéder a cette ressource !");
    }

}




  /**
     * @Route("/user/home/view-member-edit/{id}",name="view_annonce")
     */
    public function viewmemberAction(Request $request,$id)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
    {
     




     if($request->isXmlHttpRequest())
       {

           
     
      
      $membre=$em->getRepository('BackBundle:Membre')->find($id);
       $id=$membre->getId();
       $civilite=$membre->getCivilite();
      $nom=$membre->getNom();
      $prenom=$membre->getPrenom();
      $naissance=$membre->getDatenaissance()->format('d-m-Y');
      $ville=$membre->getVille();
      $adresse=$membre->getAdresse();
      $cp=$membre->getCp();
       $telephone=$membre->getTelephone();
       $telephoneII=$membre->getTelephoneII();
       $fix=$membre->getFix();
       $relation=$membre->getRelation();
          $autre=$membre->getAutres();
      $member=array('id'=>$id,'nom'=>$nom,'prenom'=>$prenom,'naissance'=>$naissance,'ville'=>$ville,'adresse'=>$adresse,'cp'=>$cp,'telephone'=>$telephone,'telephoneII'=>$telephoneII,'fix'=>$fix,'relation'=>$relation,'autre'=>$autre,'civilite'=>$civilite);
           
             
             $response=new JsonResponse(['success'=>true,'member'=>$member]);
             return $response;
        




        

       }else{
           $msg="Erreur requete";
                $response=new JsonResponse(['success'=>false,'message'=>$msg]);

                return $response;

       }

       
    }else{

          throw new AccessDeniedException("vous ne pouvez pas accéder a cette ressource !");
    }
    
   }     







     /**
     * @Route("/user/home/edit-member",name="edit_annonce")
     */
    public function editmemberAction(Request $request)
    {

      $em= $this->getDoctrine()->getManager();

    $user = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
    {
      if($request->isXmlHttpRequest()&&$request->isMethod('post'))
       {
            
            

          $id=$request->request->get('id_edit_membre');


          

          $member=$em->getRepository('BackBundle:Membre')->find($id);

          $civilite=$request->request->get('edit_civilite_membre'); 
          $nom=$request->request->get('edit_nom_membre');
           $prenom=$request->request->get('edit_prenom_membre');
          $datenaissance=$request->request->get('edit_naissance_membre');
          $newDate =\DateTime::createFromFormat('d/m/Y',$datenaissance);
           $relation=$request->request->get('edit_relation_membre');
            $ville=$request->request->get('edit_ville_membre');
             $adresse=$request->request->get('edit_adresse_membre');
              $cp=$request->request->get('edit_cp_membre');
               $telephone=$request->request->get('edit_telephone_membre');
                $telephoneII=$request->request->get('edit_telephoneII_membre');
                 $fix=$request->request->get('edit_fix_membre');
                  $autre=$request->request->get('edit_autre_membre');
               
             

                



            $member->setCivilite($civilite);
            $member->setNom($nom);
            $member->setPrenom($prenom);
            $member->setDatenaissance($newDate);
            $member->setVille($ville);
            $member->setAdresse($adresse);
            $member->setCp($cp);
            $member->setTelephone($telephone);
            $member->setTelephoneII($telephoneII);
            $member->setRelation($relation);
            $member->setFix($fix);
            $member->setAutres($autre);
            $member->setUser($user);


    $em->persist($member);
    $em->flush();

        $msg="Annonce Modifier avec success !";
                $response=new JsonResponse(['success'=>true,'message'=>$msg]);

                return $response;

       }
       else{
       
         $msg="Erreur requete";
                $response=new JsonResponse(['success'=>false,'message'=>$msg]);

                return $response;


       }


    }
    else{
      throw new AccessDeniedException("vous ne pouvez pas accéder a cette ressource !");
    
    }



}




   /**
     * @Route("/user/home/mission-demande/{categorie}",name="demande_mission")
     */
    public function affichermissionAction(Request $request,$categorie)
    {
        $output=''; 
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
     
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
    {
     




     if($request->isXmlHttpRequest())
       {

       
         $option = $em->getRepository('BackBundle:Options')->find($categorie);
        
        $missions=$em->getRepository('BackBundle:Mission')->findBy(
array('categorie'=>$option) 
);
    $nbr=count($missions);
        if(count($missions)>0)
{
  $i=0;
  $output.='<input type="hidden" value="'.$nbr.'" name="nbrcompetence"/>';
  $output.="<label>à faire :</label>";
     foreach ($missions as $mission) {
   $i++;

$output.='<div> <input type="checkbox"  name="competence_'.$i.'" class="comun_checkbox" value="'.$mission->getId().'">
  <label>'.$mission->getTitre().'</label> <div>';




     }
 }

           $response=new JsonResponse(['success'=>true,'output'=>$output]);

                return $response;

  
       }else{
           $msg="Erreur requete";
                $response=new JsonResponse(['success'=>false,'message'=>$msg]);

                return $response;

       }
}else{

          throw new AccessDeniedException("vous ne pouvez pas accéder a cette ressource !");
    }

}






   /**
     * @Route("/user/home/produit-demande/{service}",name="demande_produit")
     */
    public function afficherproduitsAction(Request $request,$service)
    {
        $output=''; 
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
     
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
    {
     




     if($request->isXmlHttpRequest())
       {

       
         $service = $em->getRepository('BackBundle:Service')->find($service);
         if($service->getTitre()=='Achat')
         {
          $output.='<label>Listes des produits:</label>';
          $output.='<textarea  class="form-control" name="listeproduits" id="listproduits" placeholder="Liste des produits"></textarea>';
         }

 

           $response=new JsonResponse(['success'=>true,'output'=>$output]);

                return $response;

  
       }else{
           $msg="Erreur requete";
                $response=new JsonResponse(['success'=>false,'message'=>$msg]);

                return $response;

       }
}else{

          throw new AccessDeniedException("vous ne pouvez pas accéder a cette ressource !");
    }

}






/**
     * @Route("/user/home/deplacement-demande/{categories}",name="demande_deplacement")
     */
    public function afficherdeplacementAction(Request $request,$categories)
    {
        $output=''; 
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
     
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
    {
     




     if($request->isXmlHttpRequest())
       {

       
         $categorie = $em->getRepository('BackBundle:Options')->find($categories);
         if($categorie->getTitre()=='Covoiturage'||$categorie->getTitre()=='Balade')
         {
          $output.='<div class="form-group col-md-6">
          <label>Départ</label>
           <input type="text" name="depart" id="depart" class="form-control" placeholder="Départ"/>
 

          </div>';
          $output.='<div class="form-group col-md-6">';

          if($categorie->getTitre()=='Covoiturage')
          {
             $output.='<label>Arrivé:</label>';
          }else{
            $output.='<label>Place à visité :</label>';
          }


          $output.=' <input type="text" name="arrive" id="arrive" class="form-control"/></div>';
          

         $output.='<div class="form-group col-md-12">
           
    <div>
  <input type="checkbox" id="currentadresse" name="currentadresse" value="currentadresse">
  <label>Considérer l&apos;adresse de votre membre comme adresse de départ</label>
</div>  
         </div>';




  
         $output.='<div class="form-group col-md-12">
         <label>Trajet</label>
         
            <div>
  <input type="radio" id="allez" name="trajet" value="allez">
  <label>Juste allez</label>
</div>


     
            <div>
  <input type="radio" id="allezretour" name="trajet" value="allezretour">
  <label>Allez et Retour</label>
</div>


         </div>';


         }

 

           $response=new JsonResponse(['success'=>true,'output'=>$output]);

                return $response;

  
       }else{
           $msg="Erreur requete";
                $response=new JsonResponse(['success'=>false,'message'=>$msg]);

                return $response;

       }
}else{

          throw new AccessDeniedException("vous ne pouvez pas accéder a cette ressource !");
    }

}














}