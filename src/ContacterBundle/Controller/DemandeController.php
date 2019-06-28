<?php

namespace ContacterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use BackBundle\Entity\Contacter;
use BackBundle\Entity\Notification;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use BackBundle\Entity\Dates;
use BackBundle\Entity\Mission;
use BackBundle\Entity\Membre;


class DemandeController extends Controller
{
    
  
 /**
     * @Route("/conacter-{id}",name="contacter_annonce")
     */
    public function contacteroffreAction(Request $request,$id)
    {

    	 $em= $this->getDoctrine()->getManager();
      $user = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) )
    { 

    if($authchecker->isGranted('ROLE_CLIENT'))
       {


        $annonce=$em->getRepository('BackBundle:Annonce')->find($id);
      $membres=$em->getRepository('BackBundle:Membre')->findBy(array('user'=>$user));

      $nbrmission=count($annonce->getMission());
      $missions=$annonce->getMission();

      $eureur=false;
      $dejacontacter=false;



       if($annonce->getTypeAnnance()=='demande')
           {
            $eureur=true;
            

           }
           
           $dcontacter=$em->getRepository('BackBundle:Contacter')->findOneBy(array('annonce'=>$annonce,'demandeur'=>$user));

           if(count($dcontacter)>0||$dcontacter!==null)
           {
             $dejacontacter=true;

           }















       return $this->render('ContacterBundle:Client:contacteroffre.html.twig',['nbrmission'=>$nbrmission,'missions'=>$missions,'annonce'=>$annonce,'membres'=>$membres,'eureur'=>$eureur,'dejacontacter'=>$dejacontacter]);


       }else{

        $eureur=false;
        $dejacontacter=false;

          $annonce=$em->getRepository('BackBundle:Annonce')->find($id);
           if($annonce->getTypeAnnance()=='offre')
           {
            $eureur=true;
           }

           if($annonce->getService()!==$user->getService())
           {
            $eureur=true;
           }

           if($user->getValid()==1)
           {
            $eureur=true;
           }
           
           $dcontacter=$em->getRepository('BackBundle:Contacter')->findOneBy(array('annonce'=>$annonce,'demandeur'=>$user));

           if(count($dcontacter)>0||$dcontacter!==null)
           {
             $dejacontacter=true;

           }





            return $this->render('ContacterBundle:Fournisseur:contacterdemande.html.twig',['annonce'=>$annonce,'eureur'=>$eureur,'dejacontacter'=>$dejacontacter]);

       } 


      
     





 
    }else{

        $route=$request->get('_route');
               

              $this->get('session')->set('referer',$route);

              $this->get('session')->set('param',$id);

    	 $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));

    }



     }






     /**
     * @Route("/user/home/form-contacter-offre",name="form_contacter_offre")
     */
    public function formcontacteroffreAction(Request $request)
    {

      $entityManager = $this->getDoctrine()->getManager();

    $user = $this->container->get('security.token_storage')->getToken()->getUser();
  
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
    {

           if($request->isXmlHttpRequest())
                     {
     
          $contacter = new Contacter();

   
  $nbrcompetence=$request->request->get('nbrmission');
  $annonce_id=$request->request->get('annonce');
  $annonce_de_agent=$request->request->get('agent');
  $annonce=$entityManager->getRepository('BackBundle:Annonce')->find($annonce_id);
  $annonceur=$entityManager->getRepository('FrontBundle:User')->find($annonce_de_agent);

   $contacter->setType('contacter_offre');
    $contacter->setEtat('attente de proposition');
    $contacter->setDatePublication(new \DateTime()); 
    $contacter->setAnnonce($annonce);
    $contacter->setDemandeur($user);
    $contacter->setAnnonceur($annonceur);

  $telephone=$request->request->get('telephone_demande_contacter');
  $telephoneII=$request->request->get('telephone2_demande_contacter');
  $fix=$request->request->get('fix_demande_contacter');
  $email=$request->request->get('email_demande_contacter');
  $ville=$request->request->get('ville_demande_contacter');
  $adresse=$request->request->get('adresse_demande_contacter');
  $cp=$request->request->get('cp_demande_contacter');

    $titre=$request->request->get('titrecontacteroffre');
      $description=$request->request->get('descriptioncontacteroffre');
      $recurence=$request->request->get('recurrence');
      $autres=$request->request->get('autrescontacteroffre');

      $contacter->setTitre($titre);
      $contacter->setDescription($description);
      $contacter->setAutres($autres);
      $contacter->setRecurrence($recurence);



 $dates=$request->request->get('datesdemande');
$tab = explode(",", $dates);

foreach ($tab as $date) {
$datesvistes=new Dates();
$newDate = \DateTime::createFromFormat('d/m/Y',$date) ;
$datesvistes->setDatev($newDate);
 $entityManager->persist($datesvistes);


      $entityManager->flush();



$contacter->addDate($datesvistes);
}

$temps=$request->request->get('tempdemande');
$timedemande = \DateTime::createFromFormat('H:i',$temps) ;
$contacter->setTempVisite($timedemande);
 

 


$achat=$request->request->get('achatcontacter');
$aporter=$request->request->get('outillesdemandecontacter');
$cordonnees=$request->request->get('affichercord-demande_contacter');

$depart=$request->request->get('departdemandecontacter');
$arriver=$request->request->get('arrivedemandecontacter');
$listeproduits=$request->request->get('listeachatcontacter');
$membresadress=$request->request->get('adressemembrecontacter');
$trajet=$request->request->get('trajet');



 if(''!== $listeproduits && null !== $listeproduits)
{
   
  $contacter->setListeachat($listeproduits); 

}

 if(''!== $depart && null !== $depart)
{
   
  $contacter->setDepart($depart); 

}

 if(''!== $arriver && null !== $arriver)
{
   
  $contacter->setArrive($arriver); 

}





 if(''!== $membresadress && null !== $membresadress)
{
    $contacter->setAdressemembre(true);

    }else{
       
       $contacter->setAdressemembre(false);
    }


 if(''!== $trajet && null !== $trajet)
{
     $contacter->setTrajet($trajet);
  
   

    }







 if(''!== $cordonnees && null !== $cordonnees)
{
    $contacter->setAcceptecontacter(true);

    }else{
       
       $contacter->setAcceptecontacter(false);
    }

     if(''!== $achat && null !== $achat)
{
    $contacter->setAchat(true);

    }else{
       
       $contacter->setAchat(false);
    }





     if(''!== $aporter && null !== $aporter)
{
    $contacter->setAport(true);

    }else{
       
       $contacter->setAport(false);
    }



  if($nbrcompetence>0)
 {
  
    for($i=1;$i<=$nbrcompetence;$i++)
    {
        $competence=$request->request->get('mission_'.$i);


            if('' !== $competence && null !== $competence)
             {
               
               $comp=$entityManager->getRepository('BackBundle:Mission')->find($competence);

                $contacter->addMission($comp);
             }    

    }
 }







$contacter->setVille($ville);
$contacter->setAdresse($adresse);  
$contacter->setCp($cp); 


$contacter->setTelephone($telephone);
$contacter->setFix($fix);
$contacter->setEmail($email);

$contacter->setTelephoneII($telephoneII);

$membres=$request->request->get('membres');

if(''!== $membres && null !== $membres)
{

 foreach ($membres as $membreid ) {
  $membre=$entityManager->getRepository('BackBundle:Membre')->find($membreid);
  $contacter->addMembre($membre);
 
 }

}

 
    




 $entityManager->persist($contacter);


      $entityManager->flush();

       $notification=new Notification();
     $notification->setSubject('Nouvelle demande');
     $text='Vous avez reçu une nouvelle demande de '.$user->getNom().' '.$user->getPrenom().' pour l&apos;offre '.$annonce->getTitre();
     $notification->setNotificationText($text);
     $notification->setStatus(0);
     $notification->setCreatedAt(new \DateTime());
     $notification->setUser($annonceur);
     $entityManager->persist($notification);
     $entityManager->flush();


        








 

                        $msg=' Votre demande a été envoyer  avec succèss ! ';
                        $response=new JsonResponse(array('success'=>true,'message'=>$msg));
                          return $response;
                     


}

     else{

       

                $msg="Eureur requet";
                $response=new JsonResponse(['success'=>false,'message'=>$msg]);
                  return $response;

          }




    
    


    }
       
    else{
      
       $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));
    }



}






     /**
     * @Route("/user/home/suivi-demande",name="suivi_demande")
     */
    public function suivivosdemandeAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
    {
      
       return $this->render('ContacterBundle:Client:suividemande.html.twig');

    }else{
     
      $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));
    
     }

 }




    /**
     * @Route("/user/home/demande-envoyer",name="demande_envoyer")
     */
    public function suividemanderequetAction(Request $request)
    {
         $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
    {

        $output=array('data'=>array());
        $status='';
    
          $contacters = $em->getRepository('BackBundle:Contacter')->findBy(
array('demandeur'=>$user,'type'=>'contacter_offre'),
array('datePublication' => 'desc'
) 
);
    
      foreach ($contacters as $contacter) {
 $id =$contacter->getId();

$Annonceur=$contacter->getAnnonceur()->getRaison();
$annonce=$contacter->getAnnonce()->getTitre();
$demande=$contacter->getTitre();
if($contacter->getEtat()=='Annuler')
{
$status='<span class="label label-danger">'.$contacter->getEtat().'</span>';
}

if($contacter->getEtat()=='attente de proposition')
{
$status='<span class="label label-warning">'.$contacter->getEtat().'</span>';
}




if($contacter->getEtat()=='En attente')
{
$status='<span class="label label-warning">'.$contacter->getEtat().'</span>';
}

if($contacter->getEtat()=='En cours')
{
$status='<span class="label label-info">'.$contacter->getEtat().'</span>';
}

if($contacter->getEtat()=='Complete')
{
$status='<span class="label label-success">'.$contacter->getEtat().'</span>';
}

if($contacter->getEtat()=='Failed')
{
$status='<span class="label label-danger">'.$contacter->getEtat().'</span>';
}

if($contacter->getEtat()=='Refuser')
{
$status='<span class="label label-danger">'.$contacter->getEtat().'</span>';
}



$datepublication=$contacter->getDatePublication()->format('Y-m-d H:i');
     





$button=' <div class="center">
                 
                    <button class="btn  btn-primary btn-sm"  data-toggle="modal" data-target="#Modalsuividemande" onclick="viewdemande('.$id.')"  style="margin-right:1px;margin-left:1px;">Voir</button>
                      <button class="btn  btn-danger btn-sm" disabled  style="margin-right:1px;margin-left:1px;">Annuler</button>
                    <button class="btn  btn-success btn-sm" disabled  style="margin-right:1px;margin-left:2px;">Confirmer</button>
                   <button class="btn  btn-default btn-sm" disabled  style="margin-left:1px;">Evaluez</button>  </div>';


if($contacter->getEtat()=='En cours')
{
 
                  $button='<div class="center">  <button class="btn  btn-primary btn-sm"  data-toggle="modal" data-target="#Modalsuividemande" onclick="viewdemande('.$id.')"  style="margin-right:1px;margin-left:1px;">Voir</button>

                  <button class="btn  btn-danger btn-sm"  data-toggle="modal" data-target="#Modalannulerdemande" onclick="annulerdemande('.$id.')"  style="margin-right:1px;margin-left:1px;">Annuler</button>
                   
                  <button class="btn  btn-success btn-sm" disabled  style="margin-right:1px;margin-left:1px;">Confirmer</button>
                   <button class="btn  btn-default btn-sm" disabled  style="margin-left:1px;">Evaluez</button> </div>';



}

if($contacter->getEtat()=='En attente')
{
  $button ='<div class="center"><button class="btn  btn-primary btn-sm"  data-toggle="modal" data-target="#Modalsuividemande" onclick="viewdemande('.$id.')"   style="margin-right:2px;margin-left:2px;">Voir</button>
     <button class="btn  btn-danger btn-sm" disabled style="margin-right:2px;margin-left:2px;" >Annuler</button>

 <button class="btn  btn-success btn-sm"   data-toggle="modal" data-target="#Paymentmydemande" onclick="paymentdemande('.$id.')"  style="margin-right:2px;margin-left:2px;">Confirmer</button>

    <button class="btn  btn-default btn-sm" disabled   style="margin-right:3px;margin-left:3px;">Evaluez</button></div>';
}



if(($contacter->getEtat()=='Complete'|| $contacter->getEtat()=='Failed')&& $contacter->getEvaluez()!==1)
{
        $button ='<div class="center"><button class="btn  btn-primary btn-sm"  data-toggle="modal" data-target="#Modalsuividemande" onclick="viewdemande('.$id.')"  style="margin-right:1px;margin-left:1px;">Voir</button>

   <button class="btn  btn-danger btn-sm" disabled  style="margin-right:1px;margin-left:1px;">Annuler</button>
 <button class="btn  btn-success btn-sm" disabled  style="margin-right:1px;margin-left:1px;">Confirmer</button>

 <button class="btn  btn-default btn-sm"  data-toggle="modal" data-target="#Evaluation" onclick="Evaluation('.$id.')"  style="margin-right:1px;margin-left:1px;">Evaluez</button></div>';
}





                    
                 



$output['data'][]=array(


 $Annonceur,
 $annonce,
 $demande,
  $datepublication,
 $status,

 $button


    );




}

 $response=new JsonResponse($output);

/*$response = new \Symfony\Component\HttpFoundation\Response(json_encode($output));
$response->headers->set('Content-Type', 'application/json');
*/return $response;

}







    else{

        $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));


    }




    

}










     /**
     * @Route("/user/home/suivi-demandes-reçues",name="suivi_demande_recu")
     */
    public function suividemanderecuAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
    {
      
       return $this->render('ContacterBundle:Fournisseur:suividemanderecu.html.twig');

    }else{
     
      $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));
    
     }

 }




    /**
     * @Route("/user/home/demande-recu",name="demande_recu")
     */
    public function suividemanderecurequetAction(Request $request)
    {
         $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
    {

        $output=array('data'=>array());
        $status='';
    
          $contacters = $em->getRepository('BackBundle:Contacter')->findBy(
array('Annonceur'=>$user,'type'=>'contacter_offre'),
array('datePublication' => 'desc'));
    
      foreach ($contacters as $contacter) {
 $id =$contacter->getId();
$annonce=$contacter->getAnnonce()->getTitre();
$Annonceur=$contacter->getDemandeur()->getNom()." ".$contacter->getDemandeur()->getPrenom();
$demande=$contacter->getTitre();
if($contacter->getEtat()=='Annuler')
{
$status='<span class="label label-danger">'.$contacter->getEtat().'</span>';
}

if($contacter->getEtat()=='attente de proposition')
{
$status='<span class="label label-warning">'.$contacter->getEtat().'</span>';
}




if($contacter->getEtat()=='En attente')
{
$status='<span class="label label-warning">'.$contacter->getEtat().'</span>';
}

if($contacter->getEtat()=='En cours')
{
$status='<span class="label label-info">'.$contacter->getEtat().'</span>';
}

if($contacter->getEtat()=='Complete')
{
$status='<span class="label label-success">'.$contacter->getEtat().'</span>';
}

if($contacter->getEtat()=='Failed')
{
$status='<span class="label label-danger">'.$contacter->getEtat().'</span>';
}


if($contacter->getEtat()=='Refuser')
{
$status='<span class="label label-danger">'.$contacter->getEtat().'</span>';
}


$datepublication=$contacter->getDatePublication()->format('Y-m-d ');
     





$button='<div class="center">
                 
                    <button class="btn  btn-primary btn-sm"  data-toggle="modal" data-target="#Modalsuividemanderecu" onclick="voiragent('.$id.')" style="margin-left:1px;margin-right:1px;" >Voir</button>
                    <button class="btn  btn-danger btn-sm" disabled style="margin-left:1px;margin-right:1px;" >Refuser</button>
                    <button class="btn  btn-success btn-sm" disabled style="margin-left:1px;margin-right:1px;" >Proposer prix</button>

                     <button class="btn  default btn-sm" disabled style="margin-left:1px;margin-right:1px;" >cloturer</button></div>';


if($contacter->getEtat()=='En cours')
{
                          $button='<div class="center"><button class="btn  btn-primary btn-sm"  data-toggle="modal" data-target="#Modalsuividemanderecu" onclick="voiragent('.$id.')" style="margin-left:1px;margin-right:1px;" >Voir</button>

                           <button class="btn  btn-danger btn-sm" disabled style="margin-left:1px;margin-right:1px;" >Refuser</button>

                        <button class="btn  btn-success btn-sm" disabled  style="margin-left:1px;margin-right:1px;">Proposer prix</button>

                    <button class="btn  btn-default btn-sm"  data-toggle="modal" data-target="#Modalfindemande" onclick="findemande('.$id.')" style="margin-left:1px;margin-right:1px;" >clôturer
 </button></div>';

  
}


if($contacter->getEtat()=='attente de proposition')
{
   $button ='<div class="center"><button class="btn  btn-primary btn-sm"  data-toggle="modal" data-target="#Modalsuividemanderecu" onclick="voiragent('.$id.')" style="margin-left:1px;margin-right:1px;" >Voir</button>
 <button class="btn  btn-danger btn-sm"  data-toggle="modal" data-target="#ModalRefuser" onclick="refuserdemande('.$id.')"  style="margin-left:1px;margin-right:1px;">Refuser
 </button>
<button class="btn  btn-success btn-sm"  data-toggle="modal" data-target="#Modalproposerprix" onclick="proposerprix('.$id.')"  style="margin-left:1px;margin-right:1px;">Proposer prix
 </button>
  <button class="btn  btn-default btn-sm" disabled style="margin-left:1px;margin-right:1px;">cloturer</button></div>';

}





                    
                 



$output['data'][]=array(



 $annonce,
$Annonceur,
 $demande,
  $datepublication,
 $status,

 $button


    );




}

 $response=new JsonResponse($output);

/*$response = new \Symfony\Component\HttpFoundation\Response(json_encode($output));
$response->headers->set('Content-Type', 'application/json');
*/return $response;

}







    else{

        $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));


    }




    

}



















    /**
     * @Route("/operation/annuler-demande/{id}",name="annuler_demande_client")
     */
    public function annulerdemandeAction(Request $request,$id)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT') ))
    {

    if($request->isXmlHttpRequest())
       {


     $contacter=$em->getRepository('BackBundle:Contacter')->find($id);

     $contacter->setEtat('Annuler');
     $titre=$contacter->getTitre();
     $annonceur=$contacter->getAnnonceur();
     $usernotif=$em->getRepository('FrontBundle:User')->find($annonceur);
     $em->persist($contacter);
     $em->flush();


     $notification=new Notification();
     $notification->setSubject('Annulation  d&apos;opération');
     $text='L&apos;opération  '.$titre. ' a été annuler par le demandeur '.$user->getNom().' '.$user->getPrenom();
     $notification->setNotificationText($text);
     $notification->setStatus(0);
     $notification->setCreatedAt(new \DateTime());
     $notification->setUser($usernotif);
     $em->persist($notification);
     $em->flush();


     $msg="Opération annuler avec succèss !";
                $response=new JsonResponse(['success'=>true,'message'=>$msg]);

                return $response;





    }else{
          $msg="Erreur requete";
                $response=new JsonResponse(['success'=>false,'message'=>$msg]);

                return $response; 
    }




} else{
      $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));

    
    }





}






 /**
     * @Route("/user/home/cloturer-demande",name="cloturer_mission_demande")
     */
    public function cloturerAction(Request $request)
    {
         $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
    {
      
     if($request->isXmlHttpRequest())
       {
        $idproposition=$request->request->get('idpropositiondemande');
        $etat=$request->request->get('optcompletedemande');
        $description=$request->request->get('descriptioneureurdemanderecu');

        $mission=$em->getRepository('BackBundle:Contacter')->find($idproposition);
        $annonceur=$mission->getDemandeur();
       // $annonceur=$em->getRepository('BackBundle:Contacter')->find($annonceurid);
        if($etat=='success')
        {
            $mission->setEtat('Complete');
        }

        else{
            $mission->setEtat('Failed'); 
        } 

        if($description!=='')
         {
            $mission->setException($description);
         } 

             $em->persist($mission);
    $em->flush();
     $text='';
    $notification=new Notification();
     $notification->setSubject('Mission complète');
     if($etat=='success')
      {
           $text='Le mission de '.$mission->getAnnonce()->getTitre().' qui vous affectez a '.$mission->getDemandeur()->getRaison().' a été terminé avec succèss';  
      }  else{
        $text='Le mission de '.$mission->getAnnonce()->getTitre().' qui vous affectez au '.$mission->getDemandeur()->getRaison().'  failed'; 
      }
  
     $notification->setNotificationText($text);
     $notification->setStatus(0);
     $notification->setCreatedAt(new \DateTime());
     $notification->setUser($annonceur);
     $em->persist($notification);
     $em->flush();



        $msg="Mission cloturé avec succèss !";
                $response=new JsonResponse(['success'=>true,'message'=>$msg]);

                return $response;
  

      
    } else{
       
         $msg="Erreur requete";
                $response=new JsonResponse(['success'=>false,'message'=>$msg]);

                return $response;


       }


} else{

    $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
    return $this->redirect( $this->generateUrl('fos_user_security_login'));

    
    }




}










  /**
     * @Route("/user/home/view-demande-client/{id}",name="view_demande_client")
     */
    public function viewpropositionclientAction(Request $request,$id)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
    {
     

    $output='';

     
     if($request->isXmlHttpRequest())
       {

           
     
      
      $contacter=$em->getRepository('BackBundle:Contacter')->find($id);
      $titre=$contacter->getTitre();
      $description=$contacter->getDescription();
      $prix=$contacter->getPrix();
      $etat=$contacter->getEtat();
      $datepublication=$contacter->getDatePublication()->format('Y-m-d');
      $autres=$contacter->getAutres();
       $offre=$contacter->getAnnonce()->getTitre();
         $descriptionoffre=$contacter->getAnnonce()->getDescription();
       $annonceur=$contacter->getAnnonceur()->getUsername();
       $time=$contacter->getTempVisite()->format('H:i');;
       $recurrence=$contacter->getRecurrence();
       $aporter=$contacter->getAport();
       $acheter=$contacter->getAchat();
       $depart=$contacter->getDepart();
       $arrive=$contacter->getArrive();
       $trajet=$contacter->getTrajet();
       $currentadresse=$contacter->getAdressemembre();
       $telephone=$contacter->getTelephone();
       $telephoneII=$contacter->getTelephoneII();
       $fix=$contacter->getFix();
       $ville=$contacter->getVille();
       $adresse=$contacter->getAdresse();
       $cp=$contacter->getCp();
       $email=$contacter->getEmail();
       $prix=$contacter->getPrix();
       $listeachat=$contacter->getListeachat();
       $dates=$contacter->getDates();
       $membres=$contacter->getMembres();
       $missions=$contacter->getMission();
        $tarification=$contacter->getTypetarification();

       $nom=$contacter->getDemandeur()->getNom();
       $prenom=$contacter->getDemandeur()->getPrenom();
       $p=$contacter->getDemandeur()->getPays();
        $a=$contacter->getDemandeur()->getAdresse();
        $c=$contacter->getDemandeur()->getCp();
         $e=$contacter->getDemandeur()->getEmail();
         $t=$contacter->getDemandeur()->getTelephone();

       $status='';

       $output.=" <div class='table-responsive'>
            <table class='table'>";



                $output.="<tr>
                <th style='width:50%'> Titre de L&apos;offre </th>
                <td >".$offre." </td></tr>
              
                ";

                 $output.="<tr>
                <th style='width:50%'> Description L&apos;offre </th>
                <td >".$descriptionoffre." </td></tr>
              
                ";


         $output.=" <tr>
                <th style='width:50%'>Cordonnées de l&apos;annonceur de l&apos;offre </th>
                <td >" ;

                $output.="Raison sociale :" .$contacter->getAnnonceur()->getRaison()."<br/>";
                $output.="Responsable :" .$contacter->getAnnonceur()->getResponsable()."<br/>";
                $output.="Zone de travaille :" .$contacter->getAnnonce()->getZone()."<br/>";
                
                $output.="telephone :" .$contacter->getAnnonceur()->getTelephone()."<br/>";
                $output.="adresse :" .$contacter->getAnnonceur()->getAdresse()." , ".$contacter->getAnnonceur()->getCp()."<br/>";

                $output.="</td></tr>";





      

        $output.=" <tr>
                <th style='width:50%'>Titre de votre demande </th>
                <td >".$titre." </td></tr>

                <tr>
                <th style='width:50%'>Description de votre demande </th>
                <td >".$description." </td></tr>
              
                ";

                 if(count($missions)>0)
       {
         $output.=" <tr>
                <th style='width:50%'>Missions  </th>
                <td > ";
          foreach ($missions as $mission ) {
         
          $output.=" ".$mission->getTitre()." <br/>";


          }

          $output.="</td></tr>";


       }






      if($recurrence=='Une')
      {
        $output.="<tr>
                <th style='width:50%'>Recurrence du besoin </th>
                <td >Une seule visite  </td></tr> ";


      }else{

        $output.="<tr>
                <th style='width:50%'>Recurrence du besoin </th>
                <td >Plusieurs visites </td></tr>";
      }
      

      if($recurrence!=='Une')
      {
          $output.="<tr>
                <th style='width:50%'>Nombres du visites </th>
                <td >".count($dates)." </td></tr>";

      }

      $output.="<tr>
                <th style='width:50%'> les Date corresponds a votre demande </th>";

                $output.="<td > ";

               foreach ($dates as $date) {
                $output.=$date->getDatev()->format('Y-m-d')."<br/>";
               }

                $output.="</td></tr>";


    $output.="<tr>
                <th style='width:50%'>Le Temps corresponds a votre demande </th>
                <td >".$time."</td></tr>";

       
      

     if(''!== $depart && null !== $depart&& $currentadresse== null)
      {
        
          
           $output.="<tr>
                <th style='width:50%'>Départ </th>
                <td >".$depart." </td></tr>";


      }

 /*     if(''!== $currentadresse && null !== $currentadresse&&$depart==null){

           $output.="<tr>
                <th style='width:50%'>Départ </th>
                <td >L&apos;adresse du visiteur  </td></tr>";

      }*/


           if(''!== $arrive && null !== $arrive)
      {
        
          
           $output.="<tr>
                <th style='width:50%'>L&apos;arrivé </th>
                <td >".$arrive." </td></tr>";


      }


          if(''!== $trajet && null !== $trajet)
      {
        
          
           $output.="<tr>
                <th style='width:50%'>Trajet </th>
                <td >".$trajet." </td></tr>";


      }


              if(''!== $listeachat && null !== $listeachat)
      {
        
          
           $output.="<tr>
                <th style='width:50%'>Liste des achats </th>
                <td >".$listeachat." </td></tr>";


      }

 
        
          
           $output.="<tr>
                <th style='width:50%'>Autres détailles </th> <td >";
                                if(''!== $autres && null !== $autres)
      {
               $output.=$autres." <br/>";
            }    
                              if(''!== $aporter && null !== $aporter)
            {
        
                $output.=" Le jobber apporte ses outilles <br/>";
              }

                                 if(''!== $acheter && null !== $acheter)
      {
        


                 $output.="Le jobber doit acheter les fournitures et les outilles indiqué dans l&apos;annonce
                 ";

 }
      

     $output.="</td></tr>";
          
         


      


      
          
        


     







         $output.="<tr>
                <th style='width:50%'>Date du contacte </th>
                <td >".$datepublication." </td></tr>";

        
         $output.="<tr>
                <th style='width:50%'>Nombres  des personnes bénifies du service </th>
                <td >".count($membres)." </td></tr>";


           $output.="<tr>
                <th style='width:50%'>Liste des membres  </th> 
                <td>";
                foreach ($membres as $membre) {

                  if(''!==$membre->getNom()&& null !==$membre->getNom())
                  {
                   $output.="Nom: ".$membre->getNom()."<br/>";  


                  }

                  if(''!==$membre->getPrenom()&& null !==$membre->getPrenom())
                  {
                   $output.="Prénom: ".$membre->getPrenom()."<br/>";  


                  }

                   if(''!==$membre->getCivilite()&& null !==$membre->getCivilite())
                  {
                   $output.="Civilité: ".$membre->getCivilite()."<br/>";  


                  }

                      if(''!==$membre->getDatenaissance()&& null !==$membre->getDatenaissance())
                  {
                   $output.="Date naissance: ".$membre->getDatenaissance()->format('Y-m-d')."<br/>";  


                  }

                         if(''!==$membre->getRelation()&& null !==$membre->getRelation())
                  {
                   $output.="Type de relation: ".$membre->getRelation()."<br/>";  


                  }


                   $output.="Adresse:".$membre->getVille()." ,".$membre->getAdresse()." ,".$membre->getCp()."<br/>";
                    $output.="Coordonnées: ";
                      if(''!==$membre->getTelephone()&& null !==$membre->getTelephone())
                      {
                         
                         $output.=$membre->getTelephone()." , ";


                      } 

                           if(''!==$membre->getTelephoneII()&& null !==$membre->getTelephoneII())
                      {
                         
                         $output.=$membre->getTelephoneII()." , ";


                      } 

                           if(''!==$membre->getFix()&& null !==$membre->getFix())
                      {
                         
                         $output.=$membre->getFix()." </br> ";


                      } 

                            if(''!==$membre->getAutres()&& null !==$membre->getAutres())
                      {

                         
                         $output.="<br/> Information complémentaires ".$membre->getAutres()." <br/> ";


                      } 


                  
                   $output.="<br/><br/>";

                
                }

                $output.="
                </td></tr>";


                 $output.="<tr>
                <th style='width:50%'>Vos coordonées  </th>
                 <td > ".$nom." ".$prenom."<br/>";
                 if($telephone!==null && $telephone !=='' )
                 {
                   $output.="Télephone: ".$telephone."<br/>";

                 }else{
                  $output.="Télephone: ".$t."<br/>";
                 }
                
                if($email!==null && $email !=='' )
                 {
                $output.="Email :".$email."<br/>";
              }else{
                  $output.="Email :".$e."<br/>";
              }

                  if($ville!==null && $ville !=='' )
                 {
                $output.="Pays :".$ville."<br/>";
                 }else{
                    $output.="Pays :".$p."<br/>";

                 }
                 
                  if($adresse!==null && $adresse !=='' )
                 {
                $output.="Adresse:".$adresse."<br/>";
                }else{
                   $output.="Adresse:".$a."<br/>";
                }

                if($cp!==null && $cp !=='' )
                 {
                $output.="Cp :".$cp."<br/>";
              }else{
                $output.="Cp :".$c."<br/>";
              }
                $output.="</td>
                </tr>

                ";





if($contacter->getEtat()=='Annuler')
{
$status='<span class="label label-danger">'.$contacter->getEtat().'</span>';
}

if($contacter->getEtat()=='attente de proposition')
{
$status='<span class="label label-warning">'.$contacter->getEtat().'</span>';
}




if($contacter->getEtat()=='En attente')
{
$status='<span class="label label-warning">'.$contacter->getEtat().'</span>';
}

if($contacter->getEtat()=='En cours')
{
$status='<span class="label label-info">'.$contacter->getEtat().'</span>';
}

if($contacter->getEtat()=='Complete')
{
$status='<span class="label label-success">'.$contacter->getEtat().'</span>';
}

if($contacter->getEtat()=='Failed')
{
$status='<span class="label label-danger">'.$contacter->getEtat().'</span>';
}

if($contacter->getEtat()=='Refuser')
{
$status='<span class="label label-danger">'.$contacter->getEtat().'</span>';
}







  $output.="<tr>
                <th style='width:50%'>Status </th>
                <td >".$status." </td></tr>";




        if(''!==$prix&& null !==$prix)
                      {
                         
                       $output.="<tr>
                <th style='width:50%'>Prix proposer par l&apos;annonceur : </th>
                <td > <span class='label label-danger'>".$prix." ".$tarification."</span> </td></tr>";


                      } 














  $output.=' 
            </table>
            </div>

            ';
     
           
             
             $response=new JsonResponse(['success'=>true,'output'=>$output]);
             return $response;
        




        

       }else{
           $msg="Erreur requete";
                $response=new JsonResponse(['success'=>false,'message'=>$msg]);

                return $response;

       }

       
    }else{

         
    $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
    return $this->redirect( $this->generateUrl('fos_user_security_login'));
    }
    
   }     









    /**
     * @Route("/demande/automatique-anulation",name="annuler_automatique_demande")
     */
    public function demandeannulerautomatiqueAction(Request $request)
    {
    
    $em = $this->getDoctrine()->getManager();
    
    if($request->isXmlHttpRequest())
       {
         $propositions=$em->getRepository('BackBundle:Contacter')->findBy(array('type'=>'contacter_offre'));

         foreach ($propositions as $proposition) {
             $datepublication=$proposition->getDatePublication()->format('Y-m-d H:i:s');
             $datepublications = \DateTime::createFromFormat('Y-m-d H:i:s', $datepublication);
                  $datenow=new \DateTime();
                  $interval=$datenow->diff($datepublications);
                  $nmbrerday=$interval->format('%a');



             if($nmbrerday>=3&&($proposition->getEtat()=='En attente'||$proposition->getEtat()=='attente de proposition'))
             {
                $proposition->setEtat('Annuler');
                $em->persist($proposition);
                $em->flush();

                  $msg="Opération annuler avec succèss !";
                $response=new JsonResponse(['success'=>true,'message'=>$msg]);
                return $response;
              

             }



         }


      } else{

        $msg="Erreur requete";
                $response=new JsonResponse(['success'=>false,'message'=>$msg]);
                return $response;
               


      }

      return new JsonResponse('fin requet');
  

    }




   
  /**
     * @Route("/user/home/view-demande-agent/{id}",name="view_demande_agent")
     */
    public function viewdemandeagentAction(Request $request,$id)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
    {
     

    $output='';

     
     if($request->isXmlHttpRequest())
       {

           
     
      
      $contacter=$em->getRepository('BackBundle:Contacter')->find($id);
      $titre=$contacter->getTitre();
      $description=$contacter->getDescription();
      $prix=$contacter->getPrix();
      $etat=$contacter->getEtat();
      $datepublication=$contacter->getDatePublication()->format('Y-m-d H:i:s');
      $autres=$contacter->getAutres();
       $offre=$contacter->getAnnonce()->getTitre();
       $descriptionoffre=$contacter->getAnnonce()->getDescription();
       $annonceur=$contacter->getAnnonceur()->getUsername();
       $time=$contacter->getTempVisite()->format('H:i');;
       $recurrence=$contacter->getRecurrence();
       $aporter=$contacter->getAport();
       $acheter=$contacter->getAchat();
       $depart=$contacter->getDepart();
       $arrive=$contacter->getArrive();
       $trajet=$contacter->getTrajet();
       $currentadresse=$contacter->getAdressemembre();
       $telephone=$contacter->getTelephone();
       $telephoneII=$contacter->getTelephoneII();
       $fix=$contacter->getFix();
       $ville=$contacter->getVille();
       $adresse=$contacter->getAdresse();
       $cp=$contacter->getCp();
       $nom=$contacter->getDemandeur()->getNom();
       $prenom=$contacter->getDemandeur()->getPrenom();
       $e=$contacter->getDemandeur()->getEmail();
        $t=$contacter->getDemandeur()->getTelephone();
        $p=$contacter->getDemandeur()->getPays();
        $a=$contacter->getDemandeur()->getAdresse();
         $c=$contacter->getDemandeur()->getCp();
       $email=$contacter->getEmail();
       $prix=$contacter->getPrix();
       $listeachat=$contacter->getListeachat();
       $dates=$contacter->getDates();
       $membres=$contacter->getMembres();
       $missions=$contacter->getMission();
       $status='';
       $tarification=$contacter->getTypetarification();

       $output.=" <div class='table-responsive'>
            <table class='table'>";



                $output.="<tr>
                <th style='width:50%'> Titre de L&apos;offre : </th>
                <td >".$offre." </td></tr>
              
                ";



                $output.="<tr>
                <th style='width:50%'> Description de L&apos;offre : </th>
                <td style='height:60px;'>".$descriptionoffre." </td></tr>
              
                ";

                 
                


                 $output.="<tr>
                <th style='width:50%'>Cordonnées du client : </th>
                 <td >".$nom." ".$prenom."<br/>";
                   if($telephone!==null && $telephone!=='')
                   {
                      $output.="Télephone: ".$telephone."<br/>";
                    }else{
                        $output.="Télephone: ".$t."<br/>";
                    }
               if($email!==null && $email!=='')
                   {
                 $output.="Email : ".$email."<br/>";
                    }else{
                       $output.="Email : ".$e."<br/>";
                    }

                    if($ville!==null && $ville!=='')
                   {
                 $output.="Pays : ".$ville."<br/>";
               }else{
                       $output.="Pays : ".$p."<br/>";
                    }
                   
                      if($adresse!==null && $adresse!=='')
                   {
                 $output.="Adresse : ".$adresse."<br/>";
                   }else{
                       $output.="Adresse : ".$a."<br/>";
                    }

                   if($cp!==null && $cp!=='')
                   {
                 $output.="Cp : ".$cp."<br/>";
                 }else{
                       $output.="Cp : ".$cp."<br/>";
                    }

                $output.="</td>
                </tr>

                ";






       if(count($missions)>0)
       {
         $output.=" <tr>
                <th style='width:50%'>Missions demandées : </th>
                <td > ";
          foreach ($missions as $mission ) {
         
          $output.=" ".$mission->getTitre()." <br/>";


          }

          $output.="</td></tr>";


       }

        $output.=" <tr>
                <th style='width:50%'>Demande </th>
                <td >".$titre." </td></tr>

                <tr>
                <th style='width:50%'>Description du demande </th>
                <td style='height:60px;'>".$description." </td></tr>
              
                ";

      if($recurrence=='Une')
      {
        $output.="<tr>
                <th style='width:50%'>Recurrence du besoin </th>
                <td >Une seule visite  </td></tr> ";


      }else{

        $output.="<tr>
                <th style='width:50%'>Recurrence du besoin </th>
                <td >Plusieurs visites </td></tr>";
      }
      

      if($recurrence!=='Une')
      {
          $output.="<tr>
                <th style='width:50%'>Nombres des visites </th>
                <td >".count($dates)." </td></tr>";

      }

      $output.="<tr>
                <th style='width:50%'> les Date corresponds a cette demande </th>";

                $output.="<td > ";

               foreach ($dates as $date) {
                $output.=$date->getDatev()->format('Y-m-d')."<br/>";
               }

                $output.="</td></tr>";


    $output.="<tr>
                <th style='width:50%'>Le Temp de visite correspond a cette demande : </th>
                <td >".$time."</td></tr>";

       
      

     if(''!== $depart && null !== $depart&& $currentadresse== null)
      {
        
          
           $output.="<tr>
                <th style='width:50%'>Départ </th>
                <td >".$depart." </td></tr>";


      }

 /*     if(''!== $currentadresse && null !== $currentadresse&&$depart==null){

           $output.="<tr>
                <th style='width:50%'>Départ </th>
                <td >L&apos;adresse du visiteur  </td></tr>";

      }*/


           if(''!== $arrive && null !== $arrive)
      {
        
          
           $output.="<tr>
                <th style='width:50%'>L&apos;arrivé </th>
                <td >".$arrive." </td></tr>";


      }


          if(''!== $trajet && null !== $trajet)
      {
        
          
           $output.="<tr>
                <th style='width:50%'>Trajet </th>
                <td >".$trajet." </td></tr>";


      }


              if(''!== $listeachat && null !== $listeachat)
      {
        
          
           $output.="<tr>
                <th style='width:50%'>Liste des achats </th>
                <td >".$listeachat." </td></tr>";


      }

 
        
          
           $output.="<tr>
                <th style='width:50%'>Autres détailles </th> <td >";
                                if(''!== $autres && null !== $autres)
      {
               $output.=$autres." <br/>";
            }    
                              if(''!== $aporter && null !== $aporter)
            {
        
                $output.=" Le jobber apporte ses outilles <br/>";
              }

                                 if(''!== $acheter && null !== $acheter)
      {
        


                 $output.="Le jobber doit acheter les fournitures et les outilles indiqué dans l&apos;annonce
                 ";

 }
      

     $output.="</td></tr>";
          
         


         $output.="<tr>
                <th style='width:50%'>Date du contacte </th>
                <td >".$datepublication." </td></tr>";

        
         $output.="<tr>
                <th style='width:50%'>Nombres  des personnes bénifies du service </th>
                <td >".count($membres)." </td></tr>";


           $output.="<tr>
                <th style='width:50%'>Liste des membres  </th> 
                <td>";
                foreach ($membres as $membre) {

                  if(''!==$membre->getNom()&& null !==$membre->getNom())
                  {
                   $output.="Nom: ".$membre->getNom()."<br/>";  


                  }

                  if(''!==$membre->getPrenom()&& null !==$membre->getPrenom())
                  {
                   $output.="Prénom: ".$membre->getPrenom()."<br/>";  


                  }

                   if(''!==$membre->getCivilite()&& null !==$membre->getCivilite())
                  {
                   $output.="Civilité: ".$membre->getCivilite()."<br/>";  


                  }

                      if(''!==$membre->getDatenaissance()&& null !==$membre->getDatenaissance())
                  {
                   $output.="Date naissance: ".$membre->getDatenaissance()->format('Y-m-d')."<br/>";  


                  }

                         if(''!==$membre->getRelation()&& null !==$membre->getRelation())
                  {
                   $output.="Type de relation: ".$membre->getRelation()."<br/>";  


                  }


                   $output.="Adresse:".$membre->getVille()." ,".$membre->getAdresse()." ,".$membre->getCp()."<br/>";
                    $output.="Coordonnées: ";
                      if(''!==$membre->getTelephone()&& null !==$membre->getTelephone())
                      {
                         
                         $output.=$membre->getTelephone()." , ";


                      } 

                           if(''!==$membre->getTelephoneII()&& null !==$membre->getTelephoneII())
                      {
                         
                         $output.=$membre->getTelephoneII()." , ";


                      } 

                           if(''!==$membre->getFix()&& null !==$membre->getFix())
                      {
                         
                         $output.=$membre->getFix()." </br> ";


                      } 

                            if(''!==$membre->getAutres()&& null !==$membre->getAutres())
                      {

                         
                         $output.="<br/> Information complémentaires ".$membre->getAutres()." <br/> ";


                      } 


                  
                   $output.="<br/><br/>";

                
                }

           





if($contacter->getEtat()=='Annuler')
{
$status='<span class="label label-danger">'.$contacter->getEtat().'</span>';
}

if($contacter->getEtat()=='attente de proposition')
{
$status='<span class="label label-warning">'.$contacter->getEtat().'</span>';
}




if($contacter->getEtat()=='En attente')
{
$status='<span class="label label-warning">'.$contacter->getEtat().'</span>';
}

if($contacter->getEtat()=='En cours')
{
$status='<span class="label label-info">'.$contacter->getEtat().'</span>';
}

if($contacter->getEtat()=='Complete')
{
$status='<span class="label label-success">'.$contacter->getEtat().'</span>';
}

if($contacter->getEtat()=='Failed')
{
$status='<span class="label label-danger">'.$contacter->getEtat().'</span>';
}

if($contacter->getEtat()=='Refuser')
{
$status='<span class="label label-danger">'.$contacter->getEtat().'</span>';
}






  $output.="<tr>
                <th style='width:50%'>Status </th>
                <td >".$status." </td></tr>";




  if(''!==$prix&& null !==$prix)
                      {
                         
                       $output.="<tr>
                <th style='width:50%'> Prix proposer: </th>
                <td > <span class='label label-danger'>".$prix." ".$tarification."</span> </td></tr>";


                      }



                      if($prix==null&&$prix==''){


             $output.="
              <tr>
                <th style='width:50%'>Proposer un prix  : </th>
                    <td>
                    <input type='hidden' value=".$id." name='idproposerprixvoir' />
                <div class='col-md-6 form-group'>
                
              <input  type='number' id='prixproposervoir' name='prixproposervoir'  class='form-control'  placeholder='Proposer un prix'/>
               <span class='text-danger' id='eureurprixproposervoir'></span>

              </div>

                <div class='col-md-6 form-group'>
               <select name='typetarificationdemande' class='form-control'>
               <option disabled selected>Type Tarification</option>
               <option value='eur'>Euro</option>
               <option value='usd'>Dollar</option>

               </select> 
               <span class='text-danger' id='eureurtypetarification'></span> 
              
              </div>

              <div class='col-md-6 form-group'>
                 <button type='submit' name='Proposervoir' id='Proposervoir' onclick='proposerprixvoirfunction()' class='btn btn-info btn-sm'> <span>Enregistrer</span><i id='spin-proposer-prix'></i></button>
                 </div>

                    
       

        

              
                
                </td>
             </form>";





                      }














  $output.=' 
            </table>
            </div>

            ';
     
           
             
             $response=new JsonResponse(['success'=>true,'output'=>$output]);
             return $response;
        




        

       }else{
           $msg="Erreur requete";
                $response=new JsonResponse(['success'=>false,'message'=>$msg]);

                return $response;

       }

       
    }else{

         
    $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
    return $this->redirect( $this->generateUrl('fos_user_security_login'));
    }
    
   }     





      /**
     * @Route("/proposer-prix/voir",name="proposer_prix_voir")
     */
    public function proposerprixvoirAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR') ))
    {

    if($request->isXmlHttpRequest())
       {

      $id= $request->request->get('idproposerprixvoir');
      $prix= $request->request->get('prixproposervoir');
      $tarification=$request->request->get('typetarificationdemande');

     $contacter=$em->getRepository('BackBundle:Contacter')->find($id);

     $contacter->setEtat('En attente');
      $contacter->setPrix($prix);
       $contacter->setTypetarification($tarification);

     $titre=$contacter->getTitre();
     $demandeur=$contacter->getDemandeur();
     $annonceur=$contacter->getAnnonceur()->getUsername();
     $usernotif=$em->getRepository('FrontBundle:User')->find($demandeur);
     $em->persist($contacter);
     $em->flush();


     $notification=new Notification();
     $notification->setSubject('Proposition du prix');
     $text='Proposition du prix'.$prix. ' pour votre demande '.$contacter->getTitre().' par '.$user->getRaison();
     $notification->setNotificationText($text);
     $notification->setStatus(0);
     $notification->setCreatedAt(new \DateTime());
     $notification->setUser($usernotif);
     $em->persist($notification);
     $em->flush();


     $msg="Proposition envoyer !";
                $response=new JsonResponse(['success'=>true,'message'=>$msg]);

                return $response;





    }else{
          $msg="Erreur requete";
                $response=new JsonResponse(['success'=>false,'message'=>$msg]);

                return $response; 
    }




} else{
      $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));

    
    }





}






      /**
     * @Route("/proposer-prix",name="proposer_prix")
     */
    public function proposerprixAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR') ))
    {

    if($request->isXmlHttpRequest())
       {

      $id= $request->request->get('idproposerprix');
      $prix= $request->request->get('prixproposer');
      $tarification= $request->request->get('typetarificationprix');

     $contacter=$em->getRepository('BackBundle:Contacter')->find($id);

     $contacter->setEtat('En attente');
      $contacter->setPrix($prix);
       $contacter->setTypetarification($tarification);

     $titre=$contacter->getTitre();
     $demandeur=$contacter->getDemandeur();
     $annonceur=$contacter->getAnnonceur()->getUsername();
     $usernotif=$em->getRepository('FrontBundle:User')->find($demandeur);
     $em->persist($contacter);
     $em->flush();


     $notification=new Notification();
     $notification->setSubject('Proposition du prix');
      $text='Proposition du prix'.$prix. ' pour votre demande '.$contacter->getTitre().' par '.$user->getRaison();
     $notification->setNotificationText($text);
     $notification->setStatus(0);
     $notification->setCreatedAt(new \DateTime());
     $notification->setUser($usernotif);
     $em->persist($notification);
     $em->flush();


     $msg="Proposition envoyer !";
                $response=new JsonResponse(['success'=>true,'message'=>$msg]);

                return $response;





    }else{
          $msg="Erreur requete";
                $response=new JsonResponse(['success'=>false,'message'=>$msg]);

                return $response; 
    }




} else{
      $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));

    
    }





}
















    /**
     * @Route("/user/home/refuser-demande/{id}",name="refuser_demande")
     */
    public function refuserdemandeAction(Request $request,$id)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR') ))
    {

    if($request->isXmlHttpRequest())
       {


     $contacter=$em->getRepository('BackBundle:Contacter')->find($id);

     $contacter->setEtat('Refuser');
     $titre=$contacter->getTitre();
     $annonceur=$contacter->getAnnonceur()->getRaison();
     $demandeur=$contacter->getDemandeur();
     $usernotif=$em->getRepository('FrontBundle:User')->find($demandeur);
     $em->persist($contacter);
     $em->flush();


     $notification=new Notification();
     $notification->setSubject('Annulation  d&apos;opération');
     $text='L&apos;opération  '.$titre. ' a été refuser par '.$annonceur;
     $notification->setNotificationText($text);
     $notification->setStatus(0);
     $notification->setCreatedAt(new \DateTime());
     $notification->setUser($usernotif);
     $em->persist($notification);
     $em->flush();


     $msg="opération terminer  avec succèss !";
                $response=new JsonResponse(['success'=>true,'message'=>$msg]);

                return $response;





    }else{
          $msg="Erreur requete";
                $response=new JsonResponse(['success'=>false,'message'=>$msg]);

                return $response; 
    }




} else{
      $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));

    
    }





}







    /**
     * @Route("evaluez/note",name="Evaluez")
     */
    public function evaluezAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT') ))
    {

    if($request->isXmlHttpRequest())
       {

      $id=$request->request->get('contacternote');
       $note=$request->request->get('note');
     $contacter=$em->getRepository('BackBundle:Contacter')->find($id);
     $idoffre=$contacter->getAnnonce();
     $offre=$em->getRepository('BackBundle:Annonce')->find($idoffre);
     $contacter->setEvaluez(1);
     
     
     $em->persist($contacter);
     $em->flush();
       $notes=$offre->getNote();
       $ev=$notes+$note;
     $offre->setNote($ev);
     $em->persist($offre);
     $em->flush();
    


     $msg="opération terminer  avec succèss !";
                $response=new JsonResponse(['success'=>true,'message'=>$msg]);

                return $response;





    }else{
          $msg="Erreur requete";
                $response=new JsonResponse(['success'=>false,'message'=>$msg]);

                return $response; 
    }




} else{
      $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));

    
    }





}






























}   