<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackBundle\Entity\Annonce;
use BackBundle\Entity\Service;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use PDO;


class DefaultController extends Controller
{
   

     /**
     * @Route("/user/home/profile-client",name="edit_profil_client")
     */
    public function editProfileAction(Request $request)
    {

    $user = $this->container->get('security.token_storage')->getToken()->getUser();
    $anciennlogo=$user->getLogo();
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
    {

     $form=$this->createFormBuilder($user)
->add('nom',TextType::Class)
->add('prenom',TextType::Class)
->add('username',TextType::Class)
->add('email',TextType::Class)
->add('telephone',TextType::Class)
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

->add('adresse',TextType::Class)
->add('cp',TextType::Class)
->add('residence', ChoiceType::class,
            [
                'label' => 'Type Resident :',
                'required' => true,
                'choices' => array(
                    'Carte_bleu' => 'Carte Bleu',
                    'Resident' => 'Resident'
                   
                ),
                'placeholder' => '--Select a Type Resident--',
            ]
        )
->add('civilite', ChoiceType::class,
            [
                'label' => 'Civilisation :',
                'required' => true,
                'choices' => array(
                    'M' => 'M',
                    'Mlle' => 'Mlle',
                    'Mme'=>'Mme'
                   
                ),
                'placeholder' => '--Select Civilisation--',
            ]
        )
->add('post',TextType::Class)

->add('logo', FileType::class, array('label' => 'Votre Image','data_class' => null))

->getForm();
$form->handleRequest($request);
if($form->isSubmitted() ){
if( $form->isValid()){

           if($form['logo']->getData() != null)
       {
          $file =$form['logo']->getData();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('logo_directory'),
                $fileName
            );

         $user->setLogo($fileName);
     }else{

     $user->setLogo($anciennlogo);
 }

//$userManager = $container->get('fos_user.user_manager');
 $this->get('fos_user.user_manager')->updateUser($user, false);

        // make more modifications to the database

        $this->getDoctrine()->getManager()->flush();

       
        if($request->isXmlHttpRequest())
                     {

                        $msg='Account Updated';
                        $response=new JsonResponse(array('success'=>true,'message'=>$msg));

                     }

    }elseif($request->isXmlHttpRequest())
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

      return $response;
    }
           


 return $this->render('BackBundle:Client:EditProfile.html.twig',['form'=>$form->createView(),'user'=>$user]);
}
    
    

    else{
       return $this->redirectToRoute('frontpage');
    
    }
    }


     /**
     * @Route("/user/home/profile-fournisseur",name="edit_profil_fournisseur")
     */
    public function editProfileFournisseurAction(Request $request)
    {

         
           $user = $this->container->get('security.token_storage')->getToken()->getUser();
    $anciennfile=$user->getFile();
    $anciennLogo=$user->getLogo();
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
    {

     $form=$this->createFormBuilder($user)

->add('username',TextType::Class)
->add('email',TextType::Class)

->add('telephone',TextType::Class)






->add('adresse',TextType::Class)
->add('cp',TextType::Class)
->add('raison',TextType::Class)
->add('ncompte',TextType::Class)



  

  ->add('responsable', null, array('attr'=>array('class'=>'form-control','placeholder'=>'Responsable')))
  ->add('tva', null, array('attr'=>array('class'=>'form-control','placeholder'=>'Numéro SIRET')) )




->add('logo', FileType::class, array('label' => 'Logo','data_class' => null))

->add('file', FileType::class, array('label' => 'Document Entreprise','data_class' => null))

->getForm();
$form->handleRequest($request);
if($form->isSubmitted() ){
if( $form->isValid()){

           if($form['file']->getData() != null)
       {
          $file =$form['file']->getData();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('document_directory'),
                $fileName
            );

         $user->setFile($fileName);
     }else{

     $user->setFile($anciennfile);
 }

        if($form['logo']->getData() != null)
       {
          $logo =$form['logo']->getData();

            // Generate a unique name for the file before saving it
            $logoName = md5(uniqid()).'.'.$logo->guessExtension();

            // Move the file to the directory where brochures are stored
            $logo->move(
                $this->getParameter('logo_directory'),
                $logoName
            );

         $user->setLogo($logoName);
     }else{

     $user->setLogo($anciennLogo);
 }


//$userManager = $container->get('fos_user.user_manager');
 $this->get('fos_user.user_manager')->updateUser($user, false);

        // make more modifications to the database

        $this->getDoctrine()->getManager()->flush();

       
        if($request->isXmlHttpRequest())
                     {

                        $msg='Profile modifier successfuly';
                        $response=new JsonResponse(array('success'=>true,'message'=>$msg));

                     }

    }elseif($request->isXmlHttpRequest())
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

      return $response;
    }

     
     


 return $this->render('BackBundle:Fournisseur:EditProfile.html.twig',['form'=>$form->createView(),'user'=>$user]);
}
    
    

    else{
       return $this->redirectToRoute('frontpage');
    
    }






























    }



      /**
     * @return string
     */
      private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }


      /**
     * @Route("/user/home/gestion-offres",name="gestion_offres")
     */
    public function offrefAction(Request $request)
    {

     $user = $this->container->get('security.token_storage')->getToken()->getUser();
      $entityManager = $this->getDoctrine()->getManager();

     $authchecker= $this->container->get('security.authorization_checker');
     if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
   {
     
       
$service=$user->getService();
$options = $entityManager->getRepository('BackBundle:Options')->findBy(
array('service'=>$service) 
);
      
 return $this->render('BackBundle:Fournisseur:gestionoffres.html.twig',['options'=>$options]);

     }
   else{
     return $this->redirectToRoute('frontpage');
    
     }



}




     /**
     * @Route("/user/home/create-offre",name="create_offre")
     */
    public function addoffreAction(Request $request)
    {

      $entityManager = $this->getDoctrine()->getManager();

    $user = $this->container->get('security.token_storage')->getToken()->getUser();
    $service=$user->getService();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
    {
     
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
        'USD' => 'usd'
        
    
        
        
       
       
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
       

$service=$user->getService();
$options = $entityManager->getRepository('BackBundle:Options')->findBy(
array('service'=>$service) 
);

    return $this->render('BackBundle:Fournisseur:addoffre.html.twig', [
        'form' => $form->createView(),'user'=>$user,'option'=>$options
    ]);  


    }
    else{
       return $this->redirectToRoute('frontpage');
    
    }



}



   





     /**
     * @Route("/user/home/all-offre",name="all-offre")
     */
    public function alloffreAction(Request $request)
    {
         $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $devis='';
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
    {

        
       $annonces=$em->getRepository('BackBundle:Annonce')->findBy(array("user"=>$user,"typeAnnance"=>'offre',"publier"=>true),array('id' => 'DESC'));
      $output=array('data'=>array());
    
      foreach ($annonces as $annonce) {
 $id =$annonce->getId();         
$titre=$annonce->getTitre();
$option=$annonce->getOption();
$prix=$annonce->getPrix();
$dev=$annonce->getDevis();
if($dev=='eur')
 {
    $devis='Euro';
 }else{
    $devis='USD';
 }   


$datepublication=$annonce->getDatePublication()->format('Y-m-d');
     





$button=' <div  class="text-center">
                 
                    <button class="btn btn-sm  btn-success"  data-toggle="modal" data-target="#myModalEditoffre" onclick="editoffre('.$id.')" ><i class="fa fa-pencil-square-o"></i> Modifier</button> 
                  <button class="btn btn-sm  btn-danger"  data-toggle="modal" data-target="#Modaloffredelete" onclick="deleteo('.$id.')" ><i class="fa fa-trash-o"></i> Supprimer</button></div>';



$output['data'][]=array(


 $titre,
 $option,
 $prix,
 $devis,
 $datepublication,
 $button


    );




}

 $response=new JsonResponse($output);

/*$response = new \Symfony\Component\HttpFoundation\Response(json_encode($output));
$response->headers->set('Content-Type', 'application/json');
*/return $response;

}







    else{

        throw new AccessDeniedException("vous ne pouvez pas accéder a cette ressource !");
    }




    

}






    /**
     * @Route("/user/home/delete-offre/{id}",name="delete_offre")
     */
    public function deleteoffreAction(Request $request,$id)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
    {
     
       if($request->isXmlHttpRequest())
       {
        $annonce=$em->getRepository('BackBundle:Annonce')->find($id);
  
    /*$em->remove($annonce);
     $em->flush();*/

     $annonce->setPublier(false);
     $em->persist($annonce);
     $em->flush();

       $msg="Offre supprimer avec success !";
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
     * @Route("/user/home/edit-offre",name="edit_offre")
     */
    public function editoffreAction(Request $request)
    {

      $em= $this->getDoctrine()->getManager();

    $user = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
    {
      if($request->isXmlHttpRequest()&&$request->isMethod('post'))
       {
            
            

          $id=$request->request->get('id_offre');


          $afficher=$request->request->get('affichercord-offre-edit');
          $typetarification=$request->request->get('edit_typetarification');
          $devis=$request->request->get('edit_devis');
        

             $nbrcompetence=$request->request->get('nbrcompetence');






          $annonce=$em->getRepository('BackBundle:Annonce')->find($id); 
            $ancienimage=$annonce->getImage();
        
           if(''!== $afficher && null !== $afficher)
{
    $annonce->setCordaffiche(true);

    }else{
       
       $annonce->setCordaffiche(false);
    }


foreach ($annonce->getMission() as $mission) {    $annonce->removeMission($mission) ;   }



if($nbrcompetence>0)
 {
  
    for($i=1;$i<=$nbrcompetence;$i++)
    {
        $competence=$request->request->get('competence_'.$i);
            if('' !== $competence && null !== $competence)
             {
               
               $comp=$em->getRepository('BackBundle:Mission')->find($competence);

                $annonce->addMission($comp);
             }    

    }
 }



















          $titre=$request->request->get('edit-titre-offre');
         $secteur=$user->getService()->getTitre();
          $description=$request->request->get('edit-description-offre');
           $prix=$request->request->get('edit-prix-offre');
           
            
             
               $zone=$request->request->get('edit-zone-offre');
                $autres=$request->request->get('edit-autre-offre');
                 
              
                  if($request->request->get('edit-image-offre')!=null)
                  {


                        

                         $file =$request->request->get('edit-image-offre');

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('logo_directory'),
                $fileName
            );

         $annonce->setImage($fileName);


              }else{
                 $annonce->setImage($ancienimage);
              }

              



     







                





            $annonce->setTitre($titre);
             $annonce->setDevis($devis);
           
            $annonce->setDescription($description);
            $annonce->setPrix($prix);
            $annonce->setZone($zone);
            $annonce->setTypetarif($typetarification);
           
            $annonce->setAutres($autres);
            $annonce->setPublier(true);
         
          


    $em->persist($annonce);
    $em->flush();

        $msg="Offre Modifier avec success !";
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
     * @Route("/user/home/view-offre/{id}",name="view_offre")
     */
    public function viewoffreAction(Request $request,$id)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
    {
     




     if($request->isXmlHttpRequest())
       {

           
     
      $htmlcompetence='';
      $annonce=$em->getRepository('BackBundle:Annonce')->find($id);
       $id=$annonce->getId();
      $titre=$annonce->getTitre();
      $description=$annonce->getDescription();
      $prix=$annonce->getPrix();
      $zone=$annonce->getZone();
      $typetarif=$annonce->getTypetarif();
      $afficher=$annonce->getCordaffiche();
      $Autres=$annonce->getAutres();
       $devis=$annonce->getDevis();
       $option=$annonce->getOption();
       $specialite=$annonce->getSpecialite();

       $competences=$em->getRepository('BackBundle:Mission')->findBy(array('categorie'=>$specialite));
       $selectedcompetences=$annonce->getMission();
       
      $nbr=count($competences);
      $nbrc=count($selectedcompetences);
     
      
      if($nbr>0)
      
      {

$i=0;
     $htmlcompetence.='<input type="hidden" value="'.$nbr.'" name="nbrcompetence" id="nbrcompetence"/>';
  $htmlcompetence.="<label>Compétence :</label>";

  

  foreach ($competences as $competence) {
    for ($j=0; $j <$nbrc ; $j++) { 
         # code...
     
        
               $i++;

                 if($competence->getId()==$selectedcompetences[$j]->getId())
                 {
                   
                   $htmlcompetence.='<div> <input type="checkbox"  name="competence_'.$i.'" class="comun_checkbox" value="'.$competence->getId().'" checked>
  <label>'.$competence->getTitre().'</label> <div>';

                 } else{


                 $htmlcompetence.='<div> <input type="checkbox"  name="competence_'.$i.'" class="comun_checkbox" value="'.$competence->getId().'">
  <label>'.$competence->getTitre().'</label> <div>';




                 }

             }
       }
      
      

      

}




  
       
      $annance=array('id'=>$id,'titre'=>$titre,'description'=>$description,'typetarif'=>$typetarif,'afficher'=>$afficher,'prix'=>$prix,'zone'=>$zone,'option'=>$option,'autres'=>$Autres,'htmlcompetence'=>$htmlcompetence,'devis'=>$devis);
           
             
             $response=new JsonResponse(['success'=>true,'annance'=>$annance]);
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
     * @Route("/user/home/tarif-option/{option}",name="tarif_option")
     */
    public function viewtarifAction(Request $request,$option)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $service=$user->getService();
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
    {
     




     if($request->isXmlHttpRequest())
       {

       
         $options = $em->getRepository('BackBundle:Options')->findOneBy(
array('titre'=>$option,'service'=>$service) 
);
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
     * @Route("/user/home/mission-option/{categorie}",name="categorie_mission")
     */
    public function affichermissionAction(Request $request,$categorie)
    {
        $output=''; 
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $service=$user->getService();
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
    {
     




     if($request->isXmlHttpRequest())
       {

       
         $option = $em->getRepository('BackBundle:Options')->findOneBy(
array('titre'=>$categorie,'service'=>$service) 
);
        
        $missions=$em->getRepository('BackBundle:Mission')->findBy(
array('categorie'=>$option) 
);
    $nbr=count($missions);
        if(count($missions)>0)
{
  $i=0;
  $output.='<input type="hidden" value="'.$nbr.'" name="nbrcompetence"/>';
  $output.="<label>Compétence :</label>";
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
     * @Route("/user/home/bar-chart-agent",name="bar-chart-agent")
     */
    public function dashbordbaragentAction(Request $request)
    {
        $chart_data=''; 
        $em = $this->getDoctrine()->getManager();


        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $service=$user->getService();
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
    {
     




     if($request->isXmlHttpRequest())
       {

  


$user_id=$user->getId();


$user_id=$user->getId();


  $sql = " 
     
SELECT mois ,count(mois) AS nbr FROM (select MONTHNAME(d.datev) AS mois from user u, dates_contacter dc,contacter c,dates d where d.id=dc.dates_id and dc.contacter_id=c.id and c.etat='En cours' and c.demandeur_id=u.id and u.id=".$user_id." or c.annonceur_id=u.id and u.id=".$user_id." union ALL select MONTHNAME(d.datev) AS mois from user u, dates_annonce da,annonce a, contacter c ,dates d where d.id=da.dates_id and da.annonce_id=a.id and a.id=c.annonce_id and c.etat='En cours' and c.demandeur_id=u.id and u.id=".$user_id." or c.annonceur_id=u.id and u.id=".$user_id.") AS REQUET1 group by mois



     ";



   
    $stmt = $em->getConnection()->prepare($sql);
    $stmt->execute();
   $missions=$stmt->fetchAll(PDO::FETCH_ASSOC);


/*  foreach ($missions as $row) {

    $chart_data.="{mois:".$row["mois"].",nbrmissions:".$row["nbr"]." } , ";
  
   }


$chart_data=substr($chart_data,0,-2);*/
 



 

           $response=new JsonResponse(['success'=>true,'missions'=>$missions]);

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
     * @Route("/user/home/geo-chart-agent",name="geo-chart-agent")
     */
    public function dashbordgeoagentAction(Request $request)
    {
       
        $em = $this->getDoctrine()->getManager();
        $output='';
        $chart_data='';

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $service=$user->getService();
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
    {
     




     if($request->isXmlHttpRequest())
       {

  


$user_id=$user->getId();





  $sql = " 
     

    SELECT Pays, COUNT(*) AS nbr FROM(SELECT DISTINCT c.ville AS Pays ,count(*) As nbr from contacter c where c.type='contacter_offre' and c.annonceur_id=".$user_id." and etat in ('En cours','Success','Failed') GROUP BY Pays union ALL SELECT DISTINCT a.ville AS Pays , COUNT(*) AS nbr from Annonce a , contacter c where a.type_annance='demande' and a.id=c.annonce_id and c.type='contacter_demande' and c.demandeur_id=".$user_id." and c.etat in ('En cours','Success','Failed') GROUP BY Pays ) AS requet GROUP BY Pays

     ";





     $chart_data.="{'Pays','Clients'}";
    $stmt = $em->getConnection()->prepare($sql);
    $stmt->execute();
   $output=$stmt->fetchAll(PDO::FETCH_ASSOC);


/*  foreach ($output as $row) {

 
      $chart_data.="{".$row["Pays"].",".$row["nbr"]." } , ";
  
   }*/


//$chart_data=substr($chart_data,0,-2);
 



 

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