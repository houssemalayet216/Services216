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

class DefaultController extends Controller
{
    
  
 /**
     * @Route("/postule-eureur",name="postule_eureur")
     */
    public function postuleeureurAction(Request $request)
    {

       $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));

    }
   


 /**
     * @Route("/postuler-offre",name="offre_pour_demande")
     */
    public function postuleroffreAction(Request $request)
    {
        $em= $this->getDoctrine()->getManager();
      $user = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
    { 

if($request->isXmlHttpRequest()&&$request->isMethod('post'))
       {
    	$idannonce=$request->request->get('demandeid');
    	$annonce= $em->getRepository('BackBundle:Annonce')->find($idannonce);

    	$iddemandeur=$request->request->get('createurid');
    	$demandeur=$em->getRepository('FrontBundle:User')->find($iddemandeur);
    	$titre=$request->request->get('titrecontact');
    	$description=$request->request->get('descriptioncontact');
    	$prix=$request->request->get('prixcontact');
        $devis=$request->request->get('prixdevis');
    	$autres=$request->request->get('autrescontact');
        $prixdouble = floatval($prix);

      
      $email=$request->request->get('emailcontact');
      $telephone=$request->request->get('telephonecontact');
      $fix=$request->request->get('fixcontact');
      $accepter=$request->request->get('acceptercontact');
      $coordonnees=$request->request->get('cordonneecompte');

    





         $contacter=new Contacter();

          if ('' !== $email && null !== $email) {
        $contacter->setEmail($email);
        }

           if ('' !== $telephone && null !== $telephone) {
        $contacter->setTelephone($telephone);
        }

           if ('' !== $fix && null !== $fix) {
        $contacter->setFix($fix);
        }
         

            if ('' !== $accepter && null !== $accepter) {
      $contacter->setAcceptecontacter(true);
        }else{
          $contacter->setAcceptecontacter(false);
        }

            if ('' !== $coordonnees && null !== $coordonnees) {
         $contacter->setCoordonneescomptes(true);
        }else{
 $contacter->setCoordonneescomptes(false);
        }


         $contacter->setType('contacter_demande');
         $contacter->setEtat('En attente');
         $contacter->setDatePublication(new \DateTime());
         $contacter->setTitre($titre);
         $contacter->setDescription($description);
         $contacter->setPrix($prixdouble);
         $contacter->setAutres($autres);
         $contacter->setAnnonce($annonce);
         $contacter->setDemandeur($user);
         $contacter->setAnnonceur($demandeur);
         $contacter->setTypetarification($devis);
    	   $em->persist($contacter);
         $em->flush();

    $notification=new Notification();
     $notification->setSubject('Nouveau offre');
     $text='Vous avez reçu une nouvelle offre de '.$user->getUsername();
     $notification->setNotificationText($text);
     $notification->setStatus(0);
     $notification->setCreatedAt(new \DateTime());
     $notification->setUser($demandeur);
     $em->persist($notification);
     $em->flush();



        $msg="Offre envoyer avec succèss !";
                $response=new JsonResponse(['success'=>true,'message'=>$msg]);

                return $response;

    } else{
       
         $msg="Erreur requete";
                $response=new JsonResponse(['success'=>false,'message'=>$msg]);

                return $response;


       }


    }  else{
      throw new AccessDeniedException("vous ne pouvez pas accéder a cette ressource !");

    
    }


}






    /**
     * @Route("/user/home/propositions",name="propositions")
     */
    public function poropositionsAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
    {


     

     $Contactacters = $em->getRepository('BackBundle:Contacter')->findBy(
array('Annonceur'=>$user),
array('datePublication' => 'desc') 
);
     $propositions=$this->get('knp_paginator')->paginate(
        $Contactacters,
        
        $request->query->get('page', 1),10);

    

    return $this->render('ContacterBundle:Client:propositions.html.twig',['propositions'=>$propositions]);

    }else{
    	throw new AccessDeniedException("vous ne pouvez pas accéder a cette ressource !");
    }



    }





    /**
     * @Route("/proposition/{{id}}",name="single_proposition")
     */
    public function poropositionAction(Request $request,$id)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT') ))
    {
      

      $proposition=$em->getRepository('BackBundle:Contacter')->find($id);
      return $this->render('ContacterBundle:Client:proposition.html.twig',['proposition'=>$proposition]);

    }else{
        throw new AccessDeniedException("vous ne pouvez pas accéder a cette ressource !");
    }


 }


  
    /**
     * @Route("/operation/annuler/{id}",name="annuler_proposition")
     */
    public function annulerAction(Request $request,$id)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT') ))
    {

    if($request->isXmlHttpRequest())
       {


     $proposition=$em->getRepository('BackBundle:Contacter')->find($id);

     $proposition->setEtat('Annuler');
     $titre=$proposition->getTitre();
     $demandeur=$proposition->getDemandeur();
     $usernotif=$em->getRepository('FrontBundle:User')->find($demandeur);
     $em->persist($proposition);
     $em->flush();


     $notification=new Notification();
     $notification->setSubject('Annulation  de mission');
     $text='Annulation  de mission '.$proposition->getAnnonce()->getTitre().' par le client  '.$proposition->getAnnonceur()->getNom() .' '.$proposition->getAnnonceur()->getPrenom();
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
      throw new AccessDeniedException("vous ne pouvez pas accéder a cette ressource !");

    
    }





}




    /**
     * @Route("/operation/automatique-anulation",name="annuler_automatique")
     */
    public function annulerautomatiqueAction(Request $request)
    {
    
    $em = $this->getDoctrine()->getManager();
    
    if($request->isXmlHttpRequest())
       {
         $propositions=$em->getRepository('BackBundle:Contacter')->findAll();

         foreach ($propositions as $proposition) {
             $datepublication=$proposition->getDatePublication()->format('Y-m-d H:i:s');
             $datepublications = \DateTime::createFromFormat('Y-m-d H:i:s', $datepublication);
       
                  $datenow=new \DateTime();
                   $interval=$datenow->diff($datepublications);
                  $nmbrerday=$interval->format('%a');

             if($nmbrerday>=3&&($proposition->getEtat()=='En attente'))
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
     * @Route("/user/home/suivi-vos-propositions",name="suivi_vos_proposition")
     */
    public function suivipropositionsAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
    {
      
       return $this->render('ContacterBundle:Fournisseur:suivipropositions.html.twig');

    }else{
     
      $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));
    
     }

 }


    /**
     * @Route("/user/home/all-propositions",name="all_propositions")
     */
    public function allclientpropositionsAction(Request $request)
    {
         $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
    {

        $output=array('data'=>array());
    
          $propositions = $em->getRepository('BackBundle:Contacter')->findBy(
array('Annonceur'=>$user),
array('datePublication' => 'desc') 
);
    
      foreach ($propositions as $proposition) {
 $id =$proposition->getId();
 $prix =$proposition->getPrix();
 $typeTarification=$proposition->getTypetarification();

$Annonceur=$proposition->getDemandeur()->getRaison();
$annonce=$proposition->getAnnonce()->getTitre();

if($proposition->getEtat()=='Annuler')
{
$status='<span class="label label-danger">'.$proposition->getEtat().'</span>';
}
if($proposition->getEtat()=='En attente')
{
$status='<span class="label label-warning">'.$proposition->getEtat().'</span>';
}

if($proposition->getEtat()=='En cours')
{
$status='<span class="label label-info">'.$proposition->getEtat().'</span>';
}

if($proposition->getEtat()=='Complete')
{
$status='<span class="label label-success">'.$proposition->getEtat().'</span>';
}

if($proposition->getEtat()=='Failed')
{
$status='<span class="label label-danger">'.$proposition->getEtat().'</span>';
}


$datepublication=$proposition->getDatePublication()->format('Y-m-d H:i:s');
     





$button=' 
                 <div class="center">
                    <button class="btn  btn-primary btn-sm"  data-toggle="modal" data-target="#Modalviewproposition" onclick="viewproposition('.$id.')"  style="margin-left:2px;margin-right:2px;" >Voir</button>
                   <button class="btn  btn-danger btn-sm" disabled  style="margin-left:2px;margin-right:2px;">Annuler</button>
                   <button class="btn  btn-sucess btn-sm" disabled  style="margin-left:2px;margin-right:2px;">Confirmer</button></div>';
                    

if($proposition->getEtat()=='En cours')
{
              $button =' <div class="center">   <button class="btn  btn-primary btn-sm"  data-toggle="modal" data-target="#Modalviewproposition" onclick="viewproposition('.$id.')"  style="margin-left:2px;margin-right:2px;">Voir</button>
                 
                    <button class="btn  btn-danger btn-sm"  data-toggle="modal" data-target="#Modalannulermission" onclick="annulero('.$id.')"  style="margin-left:2px;margin-right:2px;">Annuler</button>

                     <button class="btn  btn-success btn-sm" disabled  style="margin-left:2px;margin-right:2px;">Confirmer</button></div>';

}

if($proposition->getEtat()=='En attente')
{

 $button =' <div class="center">   <button class="btn  btn-primary btn-sm"  data-toggle="modal" data-target="#Modalviewproposition" onclick="viewproposition('.$id.')"  style="margin-left:2px;margin-right:2px;">Voir</button>
 <button class="btn  btn-success btn-sm" disabled  style="margin-left:2px;margin-right:2px;">Annuler</button>
<button class="btn  btn-success btn-sm"  data-toggle="modal" data-target="#Paymentproposition" onclick="paymentproposition('.$id.')"  style="margin-left:2px;margin-right:2px;">Confirmer</button></div>';
}






$button.='</div>'; 


                    
                 



$output['data'][]=array(


 $Annonceur,
 $annonce,
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

        throw new AccessDeniedException("vous ne pouvez pas accéder a cette ressource !");
    }




    

}

































 /**
     * @Route("/user/home/tout-propositions",name="tout_propositions")
     */
    public function toutfournisseurpropositionsAction(Request $request)
    {
         $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $status='';
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
    {
        $output=array('data'=>array());
        
    
          $propositions = $em->getRepository('BackBundle:Contacter')->findBy(
array('demandeur'=>$user),
array('datePublication' => 'desc') 
);
    
      foreach ($propositions as $proposition) {
 $id =$proposition->getId();

$Annonceur=$proposition->getAnnonceur()->getNom() ." ".$proposition->getAnnonceur()->getPrenom();
$annonce=$proposition->getAnnonce()->getTitre();

if($proposition->getEtat()=='Annuler')
{
$status='<span class="label label-danger">'.$proposition->getEtat().'</span>';
}
if($proposition->getEtat()=='En attente')
{
$status='<span class="label label-warning">'.$proposition->getEtat().'</span>';
}

if($proposition->getEtat()=='En cours')
{
$status='<span class="label label-info">'.$proposition->getEtat().'</span>';
}

if($proposition->getEtat()=='Complete')
{
$status='<span class="label label-success">'.$proposition->getEtat().'</span>';
}

if($proposition->getEtat()=='Failed')
{
$status='<span class="label label-danger">'.$proposition->getEtat().'</span>';
}


$str=$proposition->getDatePublication()->format('Y-m-d');
    





$button=' <div class="center">
                 
                    <button class="btn  btn-primary btn-sm"  data-toggle="modal" data-target="#Modalvoirtousproposition" onclick="voirpropositionfournisseur('.$id.')"  style="margin-left:2px;margin-right:2px;">Voir</button>
                     <button class="btn  btn-success btn-sm" disabled  style="margin-left:2px;margin-right:2px;" >Cloturer</button></div>
'; 
if($proposition->getEtat()=='En cours')
{
 
                 
                  

 $button =

'<div class="center"><button class="btn  btn-primary btn-sm"  data-toggle="modal" data-target="#Modalvoirtousproposition" onclick="voirpropositionfournisseur('.$id.')" style="margin-left:2px;margin-right:2px;" >Voir</button>
<button class="btn  btn-success btn-sm"  data-toggle="modal" data-target="#Modalfinmission" onclick="finmission('.$id.')" style="margin-left:2px;margin-right:2px;">clôturer
 </button></div>';
}





                 



$output['data'][]=array(


 $Annonceur,
 $annonce,
$str,
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

        throw new AccessDeniedException("vous ne pouvez pas accéder a cette ressource !");
    }




    

}






private function get_timeago( $ptime )
{
    $estimate_time = time() - $ptime;

    if( $estimate_time < 1 )
    {
        return 'less than 1 second ago';
    }

    $condition = array( 
                12 * 30 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $estimate_time / $secs;

        if( $d >= 1 )
        {
            $r = round( $d );
            return  $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
        }
    }
}





 /**
     * @Route("/user/home/cloturer",name="cloturer_mission")
     */
    public function cloturerAction(Request $request)
    {
         $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
    {
      
     if($request->isXmlHttpRequest()&&$request->isMethod('POST'))
       {
        $idproposition=$request->request->get('idproposition');
        $etat=$request->request->get('optcomplete');
        $description=$request->request->get('eureurmissiondescription');

        $mission=$em->getRepository('BackBundle:Contacter')->find($idproposition);
        $annonceur=$mission->getAnnonceur();
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
      throw new AccessDeniedException("vous ne pouvez pas accéder a cette ressource !");

    
    }




}











   
  /**
     * @Route("/user/home/view-proposition-agent/{id}",name="view_proposition_agent")
     */
    public function viewpropositionagentAction(Request $request,$id)
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
      $datepublication=$contacter->getDatePublication()->format('Y-m-d');
      $autrescontacte=$contacter->getAutres();

    
       $Nomannonceur=$contacter->getAnnonceur()->getNom();
        $Prenomannonceur=$contacter->getAnnonceur()->getPrenom();
        $t=$contacter->getAnnonceur()->getTelephone();
        $e=$contacter->getAnnonceur()->getEmail();
        $p=$contacter->getAnnonceur()->getPays();
        $ad=$contacter->getAnnonceur()->getAdresse();
        $c=$contacter->getAnnonceur()->getCp();




       $demande=$contacter->getAnnonce()->getTitre();
       $descriptiondemande=$contacter->getAnnonce()->getDescription();
       $autres=$contacter->getAnnonce()->getAutres();
       $service=$contacter->getAnnonce()->getService()->getTitre();
       $categorie=$contacter->getAnnonce()->getSpecialite()->getTitre();
       $time=$contacter->getAnnonce()->getDatePrevu()->format('H:i');
       $recurrence=$contacter->getAnnonce()->getTypeVisite();
       $aporter=$contacter->getAnnonce()->getAport();
       $acheter=$contacter->getAnnonce()->getAchat();
       $depart=$contacter->getAnnonce()->getDepart();
       $arrive=$contacter->getAnnonce()->getArrive();
       $trajet=$contacter->getAnnonce()->getTrajet();
       $currentadresse=$contacter->getAnnonce()->getAdressmembre();
       $telephone=$contacter->getAnnonce()->getTelephone();
       $telephoneII=$contacter->getAnnonce()->getTelephoneII();
       $fix=$contacter->getAnnonce()->getFix();
       $ville=$contacter->getAnnonce()->getVille();
       $adresse=$contacter->getAnnonce()->getAdresse();
       $cp=$contacter->getAnnonce()->getCp();
       $email=$contacter->getAnnonce()->getEmail();
       
       $listeachat=$contacter->getAnnonce()->getProduits();
       $dates=$contacter->getAnnonce()->getDates();
       $membres=$contacter->getAnnonce()->getMembres();
       $missions=$contacter->getAnnonce()->getMission();
       $status='';
     

       $output.=" <div class='table-responsive'>
            <table class='table'>";


               
                 $output.="<tr>
                <th style='width:50%'>Cordonnées de client : </th><td>
                Nom : ".$Nomannonceur."<br/>
                Prènom : ".$Prenomannonceur."<br/>";
                  if($telephone !==null && $telephone !=='')
                    {
                      $output.="Télephone : ".$telephone."<br/>";   
                    }else{
                       $output.="Télephone : ".$t."<br/>";
                    }

                 if($email !==null && $email !=='')
                    {
               $output.= "Email : ".$email."<br/>";
                    }else{
                $output.= "Email : ".$e."<br/>";  
                    }

                 if($ville !==null && $ville !=='')
                    {
                $output.="Pays : ".$ville."<br/>";
                   }else{
                     $output.="Pays : ".$p."<br/>";
                   }

                    if($adresse !==null && $adresse !=='')
                    {
                $output.="Adresse : ".$adresse."<br/>";
                    }else{
                $output.="Adresse : ".$a."<br/>";    
                    }
              

               if($cp !==null && $cp !=='')
                    {
               $output.=" Cp : ".$cp."<br/>";
                    }else{
                  $output.=" Cp : ".$c."<br/>";      
                    }
                $output.="</td>
                </tr>

                ";
              

                 
              





                $output.="<tr>
                <th style='width:50%'>Service </th>
                <td>".$service."</td>
                </tr>";

                 $output.="<tr>
                <th style='width:50%'>Catégorie </th>
                <td>".$categorie."</td>
                </tr>";

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
                <th style='width:50%'>Titre du demande </th>
                <td >".$demande." </td></tr>

                <tr>
                <th style='width:50%'>Description du demande </th>
                <td >".$descriptiondemande." </td></tr>
              
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


                  
                   $output.="</td><br/><br/>";

                
                }

           





if($contacter->getEtat()=='Annuler')
{
$status='<span class="label label-danger">'.$contacter->getEtat().'</span>';
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

$cur='';
$devv=$contacter->getTypetarification();
if($devv=='eur')
{
    $cur='Euro';
}else{
   $cur='USD'; 
}




  $output.="<tr>
                <th style='width:50%'>Votre Proposition </th>
                <td >Titre :   ".$titre." <br/>
                  Description : ".$description." <br/>
                  Prix :  <span class='label label-danger'>".$prix." ".$cur."</span> <br/>
                  Date du contactr : ".$datepublication." <br/>";
                  

            if($autrescontacte !=null&& $autrescontacte!= '' )
            {
              $output.="Autres : ".$autrescontacte." </td></tr>";
            }    



                








  $output.="<tr>
                <th style='width:50%'>Status </th>
                <td >".$status." </td></tr>";


















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
     * @Route("/user/home/view-proposition-client/{id}",name="view_proposition_client")
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
      $autrescontacte=$contacter->getAutres();

    
        $raison=$contacter->getDemandeur()->getRaison();
        $responsable=$contacter->getDemandeur()->getResponsable();
        $t=$contacter->getDemandeur()->getTelephone();
         $e=$contacter->getDemandeur()->getEmail();
         $a=$contacter->getDemandeur()->getAdresse();
         $c=$contacter->getDemandeur()->getCp();


        $telephone=$contacter->getTelephone();
        $telephoneII=$contacter->getTelephoneII();
         $fix=$contacter->getFix();
          $email=$contacter->getEmail();

 




       $demande=$contacter->getAnnonce()->getTitre();
       $descriptiondemande=$contacter->getAnnonce()->getDescription();
       $autres=$contacter->getAnnonce()->getAutres();
       $service=$contacter->getAnnonce()->getService()->getTitre();
       $categorie=$contacter->getAnnonce()->getSpecialite()->getTitre();
       $time=$contacter->getAnnonce()->getDatePrevu()->format('H:i');
       $recurrence=$contacter->getAnnonce()->getTypeVisite();
       $aporter=$contacter->getAnnonce()->getAport();
       $acheter=$contacter->getAnnonce()->getAchat();
       $depart=$contacter->getAnnonce()->getDepart();
       $arrive=$contacter->getAnnonce()->getArrive();
       $trajet=$contacter->getAnnonce()->getTrajet();
       $currentadresse=$contacter->getAnnonce()->getAdressmembre();
    /*   $telephone=$contacter->getAnnonce()->getTelephone();
       $telephoneII=$contacter->getAnnonce()->getTelephoneII();
       $fix=$contacter->getAnnonce()->getFix();
       $ville=$contacter->getAnnonce()->getVille();
       $adresse=$contacter->getAnnonce()->getAdresse();
       $cp=$contacter->getAnnonce()->getCp();
       $email=$contacter->getAnnonce()->getEmail();*/
       
       $listeachat=$contacter->getAnnonce()->getProduits();
       $dates=$contacter->getAnnonce()->getDates();
       $membres=$contacter->getAnnonce()->getMembres();
       $missions=$contacter->getAnnonce()->getMission();
       $status='';
     

       $output.=" <div class='table-responsive'>
            <table class='table'>";


               
                 $output.="<tr>
                <th style='width:50%'>Cordonnées de l'Agent/société : </th><td>
                Raison social : ".$raison."</br>
                 Responsable : ".$responsable."</br>";
                 if($telephone!==null&&$telephone!=='')
                 {
                  $output.="Telephone : ".$telephone."<br/>";  
              }else{
                $output.="Telephone : ".$t."<br/>";  
              }
                 
                if($telephoneII !=null &&$telephoneII !='')
                {
                  $output.= "Telephone 2 : ".$telephoneII."<br/>";
                }
                 if($fix !=null &&$fix !='')
                {
                  $output.= "Fix : ".$fix."<br/>";
                }
               
                if($email!==null&&$email!=='')
                 {

               $output.= "Email : ".$email."<br/>
              

                ";
            }else{
                $output.="Email : ".$e."<br/>";  
              }
              $output.= "Adresse : ".$a."<br/>";
              $output.= "Cp : ".$c."</td></tr>";








                $output.="<tr>
                <th style='width:50%'>Service </th>
                <td>".$service."</td>
                </tr>";

                 $output.="<tr>
                <th style='width:50%'>Catégorie </th>
                <td>".$categorie."</td>
                </tr>";

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
                <th style='width:50%'>Titre du demande </th>
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


                  
                   $output.="</td><br/><br/>";

                
                }

           





if($contacter->getEtat()=='Annuler')
{
$status='<span class="label label-danger">'.$contacter->getEtat().'</span>';
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

$dv='';
$deviss=$contacter->getTypetarification();
if($deviss=='eur')
{
$dv='Euro';
}else{
 $dv='USD';   
}



  $output.="<tr>
                <th style='width:50%'>Proposition Reçu </th>
                <td >Titre :   ".$titre." <br/>
                  Description : ".$description." <br/>
                  Prix :  <span class='label label-danger'>".$prix." ".$dv."</span> <br/>
                  Date du contactr : ".$datepublication." <br/>";
                  

            if($autrescontacte !=null&& $autrescontacte!= '' )
            {
              $output.="Autres : ".$autrescontacte." </td></tr>";
            }    







                











  $output.="<tr>
                <th style='width:50%'>Status </th>
                <td >".$status." </td></tr>";


















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







































































}