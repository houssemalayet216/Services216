<?php

namespace AdminBundle\Controller;

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
use BackBundle\Entity\Notification;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use BackBundle\Form\MembreType;
use BackBundle\Entity\Membre;
use BackBundle\Entity\Dates;
use Symfony\Component\Validator\Constraints\DateTime;


class DefaultController extends Controller
{
    /**
     * @Route("/admin_tableau_bord" , name="tableau_de_bord")
     */
    public function adminAction()
    {


          $user = $this->container->get('security.token_storage')->getToken()->getUser();
      $entityManager = $this->getDoctrine()->getManager();

        $authchecker= $this->container->get('security.authorization_checker');
     if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_SUPER_ADMIN')))
   {
     
      $transactions=$entityManager->getRepository('BackBundle:facturation')->findBy(array(),array('datepayment'=>'DESC'),5);

       $offres=$entityManager->getRepository('BackBundle:Annonce')->findBy(array('typeAnnance'=>'offre'));

       $countoffres=count($offres);
       $demandes=$entityManager->getRepository('BackBundle:Annonce')->findBy(array('typeAnnance'=>'demande'));
        $countdemandes=count($demandes);
       $queryagents = $this->getDoctrine()->getEntityManager()
            ->createQuery(
                'SELECT u FROM FrontBundle:User u WHERE u.roles LIKE :role' 
            )->setParameter('role', '%"ROLE_FOURNISSEUR"%');

$agents = $queryagents->getResult();
$countagents=count($agents);

      $queryclients = $this->getDoctrine()->getEntityManager()
            ->createQuery(
                'SELECT u FROM FrontBundle:User u WHERE u.roles LIKE :role  '
            )->setParameter('role', '%"ROLE_CLIENT"%');

$clients = $queryclients->getResult();
       $countclients=count($clients);

        return $this->render('AdminBundle:Default:espaceadmin.html.twig',['transactions'=>$transactions,'offres'=>$countoffres,'demandes'=>$countdemandes,'clients'=>$countclients,'agents'=>$countagents]);
    }else{

            $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));




    }
}


    /**
     * @Route("/activation-compte" , name="activation_compte")
     */
    public function activationAction()
    {


          $user = $this->container->get('security.token_storage')->getToken()->getUser();
      $entityManager = $this->getDoctrine()->getManager();

        $authchecker= $this->container->get('security.authorization_checker');
     if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_SUPER_ADMIN')))
   {
     
     
    

        return $this->render('AdminBundle:Default:activation.html.twig');
    }else{

            $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));




    }
}



























  /**
     * @Route("/transactions" , name="transactions_admin")
     */
    public function transactionAction()
    {


          $user = $this->container->get('security.token_storage')->getToken()->getUser();
      $entityManager = $this->getDoctrine()->getManager();

        $authchecker= $this->container->get('security.authorization_checker');
     if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_SUPER_ADMIN')))
   {
     
     
    

        return $this->render('AdminBundle:Default:transaction.html.twig');
    }else{

            $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));




    }
}









  /**
     * @Route("/admin/messages" , name="admin_message")
     */
    public function messagesAction()
    {


          $user = $this->container->get('security.token_storage')->getToken()->getUser();
      $entityManager = $this->getDoctrine()->getManager();

        $authchecker= $this->container->get('security.authorization_checker');
     if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_SUPER_ADMIN')))
   {
     



        return $this->render('AdminBundle:Default:messages.html.twig');
    }else{

            $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));




    }
}







  /**
     * @Route("/all/messages" , name="all_message_admin")
     */
    public function allmessagesAction(Request $request)
    {

     $user = $this->container->get('security.token_storage')->getToken()->getUser();
      $entityManager = $this->getDoctrine()->getManager();
      $status='';

     $authchecker= $this->container->get('security.authorization_checker');
     if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_SUPER_ADMIN')))
   {
     
      if($request->isXmlHttpRequest())
                     {
       

      $messages=$entityManager->getRepository('BackBundle:Message')->findBy(array(),array('datedenvoi' => 'DESC'));
      $output=array('data'=>array());
    
      foreach ($messages as $message) {
 $id =$message->getId();         
$nom=$message->getNom();
$prenom=$message->getPrenom();
$sujet=$message->getSujet();

$dateenvoi=$message->getDatedenvoi()->format('d-m-Y');


$s=$message->getStatus();
if($s=='En attente')
{
$status='<span class="label label-warning">'.$message->getStatus().'</span>';
}else{

$status='<span class="label label-success">'.$message->getStatus().'</span>';

}	
     





$button=' <div  class="text-center">
                 
                    <button class="btn  btn-default btn-sm"  data-toggle="modal" data-target="#modalvoirmessage" onclick="voirmessageadmin('.$id.')" > voir</button> 
                  <button class="btn  btn-default btn-sm"  data-toggle="modal" data-target="#modalrepondre" onclick="repondremessage('.$id.')" >Repondre</button></div>';



$output['data'][]=array(


 $nom,
 $prenom,
 $sujet,
$status,
 $dateenvoi,
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

        $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));
    }










}  












  /**
     * @Route("/repondre/message" , name="repondre_message")
     */
    public function repondreAction(Request $request)
    {

     $user = $this->container->get('security.token_storage')->getToken()->getUser();
      $entityManager = $this->getDoctrine()->getManager();

     $authchecker= $this->container->get('security.authorization_checker');
     if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_SUPER_ADMIN')))
   {
     
      if($request->isXmlHttpRequest())
                     {
       

       $idmessage=$request->request->get('idmessage');
       $sujet=$request->request->get('sujet_message');
       $text=$request->request->get('message_admin');

      $message=$entityManager->getRepository('BackBundle:Message')->find($idmessage);
    
$email=$message->getAdresse();




    $mail = \Swift_Message::newInstance()
        ->setSubject($sujet)
        ->setFrom('houssemalayet17@gmail.com')
        ->setTo($email)
        ->setBody($text);

       
    $this->get('mailer')->send($mail);

 $message->setStatus('Terminé');
            $entityManager->persist($message);


      $entityManager->flush();





  $msg="Votre message a été envoyer avec success";
                $response=new JsonResponse(['success'=>true,'message'=>$msg]);

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
     * @Route("/voir-message-admin" , name="voir_message_admin")
     */
    public function voirmessageAction(Request $request)
    {

     $user = $this->container->get('security.token_storage')->getToken()->getUser();
      $entityManager = $this->getDoctrine()->getManager();
      $status='';
      $output='';

     $authchecker= $this->container->get('security.authorization_checker');
     if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_SUPER_ADMIN')))
   {
     
      if($request->isXmlHttpRequest())
                     {
       
           $idmessage=$request->request->get('id');
      $message=$entityManager->getRepository('BackBundle:Message')->find($idmessage);
    $etat=$message->getStatus();
    
    $message->setStatus('Terminé');
            $entityManager->persist($message);

    if($etat=='Terminé' )
    {
       
      $status='<span class="label label-success">'.$message->getStatus().'</span>';

    }else{

     $status='<span class="label label-warning">'.$message->getStatus().'</span>';

    }



        
           $output.=" <div class='table-responsive'>
            <table class='table'>";


               
                 $output.="<tr>
                <th style='width:50%'>Nom : </th><td>
                 ".$message->getNom()."
                </td>
                </tr>

                ";


                  $output.="<tr>
                <th style='width:50%'>Prenom : </th><td>
                 ".$message->getPrenom()."
                </td>
                </tr>

                ";

                   $output.="<tr>
                <th style='width:50%'>Email : </th><td>
                 ".$message->getAdresse()."
                </td>
                </tr>

                ";

                 $output.="<tr>
                <th style='width:50%'>Sujet : </th><td>
                 ".$message->getSujet()."
                </td>
                </tr>

                ";

                 $output.="<tr style='height:200px;'>
                <th >Message : </th><td>
                 ".$message->getMessage()."
                </td>
                </tr>

                ";



                  $output.="<tr>
                <th style='width:50%'>Status : </th><td>
                 ".$status."
                </td>
                </tr>

                ";


            


                $output.="</table>
              </div>

                ";








 $response=new JsonResponse(array('output'=>$output));


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
     * @Route("/all/transaction" , name="all_transaction")
     */
    public function alltransactionAction(Request $request)
    {

     $user = $this->container->get('security.token_storage')->getToken()->getUser();
      $entityManager = $this->getDoctrine()->getManager();
      $status='';

     $authchecker= $this->container->get('security.authorization_checker');
     if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_SUPER_ADMIN')))
   {
     
      if($request->isXmlHttpRequest())
                     {
       

       $transactions=$entityManager->getRepository('BackBundle:facturation')->findBy(array(),array('datepayment'=>'DESC'));
      $output=array('data'=>array());
    
      foreach ($transactions as $transaction) {
 $id =$transaction->getId();         
$benificaire=$transaction->getAgent()->getRaison();
$client=$transaction->getClient()->getUsername();
$service=$transaction->getAnnonce()->getService()->getTitre();
$montant=$transaction->getMontant();
$devis=$transaction->getTarification();

$etat=$transaction->getContacter()->getEtat();

if($etat=='En cours')
{

$status='<span class="label label-primary">'.$etat.'</span>';

}
if($etat=='Complete')
{

    $status='<span class="label label-success">'.$etat.'</span>';

}  
if($etat=='Failed')
{

  $status='<span class="label label-danger">'.$etat.'</span>';

}






$datepayment=$transaction->getDatepayment()->format('Y-m-d H:i');
     





$button=' <div  class="text-center">
                 
                    <button class="btn  btn-primary btn-sm"  data-toggle="modal" data-target="#modalvoirtransaction" onclick="voirtransactionadmin('.$id.')" > voir</button> 
                  ';



$output['data'][]=array(


 
 $benificaire,
 $client,
 $service,
 $montant,
  $devis,
$status,
 $datepayment,
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

        $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));
    }










}  




 /**
     * @Route("/activation/compte" , name="all_compte")
     */
    public function alltcompteAction(Request $request)
    {

     $user = $this->container->get('security.token_storage')->getToken()->getUser();
      $entityManager = $this->getDoctrine()->getManager();
      $status='';

     $authchecker= $this->container->get('security.authorization_checker');
     if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_SUPER_ADMIN')))
   {
     
      if($request->isXmlHttpRequest())
                     {
       

       $query = $this->getDoctrine()->getEntityManager()
            ->createQuery(
                'SELECT u FROM FrontBundle:User u WHERE u.roles LIKE :role  AND u.valid = :valid'
            )->setParameter('role', '%"ROLE_FOURNISSEUR"%')->setParameter('valid', 1);

$agents = $query->getResult();




      $output=array('data'=>array());
       $etat='';
      foreach ($agents as $agent) {
 $id =$agent->getId();         
$raison=$agent->getRaison();
$responsable=$agent->getResponsable();
$service=$agent->getService()->getTitre();

$status.='<span class="label label-danger">Inactive</span>'; 












     





$button=' <div  class="text-center">
                 
                    <button class="btn  btn-primary btn-sm"  data-toggle="modal" data-target="#modalvoircompte" onclick="voircompte('.$id.')" > voir</button> 

                        <button class="btn  btn-success btn-sm"  data-toggle="modal" data-target="#modalactivercompte" onclick="activercompte('.$id.')" >Activé</button> 

                        <button class="btn  btn-warning btn-sm"   onclick="envoyermail('.$id.')" > Envoyer Email</button> 



                    </div>
                  ';



$output['data'][]=array(


 
 $raison,
 $responsable,
 $service,
 $status,
  

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

        $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));
    }










}  















 /**
     * @Route("/voir-transaction" , name="voir_transaction")
     */
    public function viewtransactionAction(Request $request)
    {

     $user = $this->container->get('security.token_storage')->getToken()->getUser();
      $entityManager = $this->getDoctrine()->getManager();
      $status='';
      $output='';

        $recurence='';
       $Dates='';
       $pays='';
       $adresseclient='';
       $cpclient='';
       $telephone='';
       $telephoneII='';

     $authchecker= $this->container->get('security.authorization_checker');
     if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_SUPER_ADMIN')))
   {
     
      if($request->isXmlHttpRequest())
                     {
       
           $id=$request->request->get('id');
      $facture=$entityManager->getRepository('BackBundle:facturation')->find($id);
       
       $raison=$facture->getAgent()->getRaison();
       $responsable=$facture->getAgent()->getResponsable();
       $siret=$facture->getAgent()->getTva();
       $ncompte=$facture->getAgent()->getNcompte();
       $Adresse=$facture->getAgent()->getAdresse();
       $cp=$facture->getAgent()->getCp();
       $mail=$facture->getAgent()->getEmail();
       $t=$facture->getAgent()->getTelephone();

       $nom=$facture->getClient()->getNom(); 
       $prenom=$facture->getClient()->getPrenom();
       $emailclient=$facture->getClient()->getEmail();
       $py=$facture->getClient()->getPays();
       $ad=$facture->getClient()->getAdresse();
       $cpc=$facture->getClient()->getCp();
       


      $service=$facture->getAnnonce()->getService()->getTitre();
      $categorie=$facture->getAnnonce()->getSpecialite()->getTitre();
     
      $montant=$facture->getMontant();
      $devis=$facture->getTarification();
   

      $datepayment=$facture->getDatepayment()->format('Y-m-d H:i');

    $typeannonce=$facture->getContacter()->getType();

    if($typeannonce=='contacter_demande')
     {
       $recurrence=$facture->getAnnonce()->getTypeVisite();
        $pays=$facture->getAnnonce()->getVille();
       
       $adresseclient=$facture->getAnnonce()->getAdresse();
       $cpclient=$facture->getAnnonce()->getCp();
       $telephone=$facture->getAnnonce()->getTelephone();
       $telephoneII=$facture->getAnnonce()->getTelephoneII();

       $dates=$facture->getAnnonce()->getDates();


   



     }else{

       
       $recurrence=$facture->getContacter()->getRecurrence();
        $pays=$facture->getContacter()->getVille();

       $adresseclient=$facture->getContacter()->getAdresse();
       $cpclient=$facture->getContacter()->getCp();
       $telephone=$facture->getContacter()->getTelephone();
       $telephoneII=$facture->getContacter()->getTelephoneII();

       $dates=$facture->getContacter()->getDates();
    

     }



  $rc='';

  if($recurrence=='Une')
  {
    $rc='Une seule visite';
  }else{
    $rc='Plusieurs visite';
  }


        

   

 


        
           $output.=" <div class='table-responsive'>
            <table class='table'>";


               
                 $output.="<tr>
                <th style='width:50%'>Information sur société /l&apos;agent : </th><td>
                 Raison social : ".$raison."<br/>
                 Responsable : ".$responsable."<br/>
                 Numéro siret : ".$siret."<br/>";
                 if($ncompte!==null && $ncompte!=='')
                 {
                  $output.="Compte bancaire : <span class='label label-danger'>".$ncompte." </span></br>";
                 }
                 




                  $output.=" Adresse : ".$Adresse." , ".$cp."<br/>
                 Email : ".$mail."<br/>
                  Telephone : ".$t."<br/>

                </td>
                </tr>

                ";
$dv='';
if($devis=='eur')
{
$dv='Euro';
}else{
$dv='USD';
}



                  $output.="<tr>
                <th style='width:50%'>Information sur le  client : </th><td>
                 Nom : ".$nom." <br/>
                 Prénom : ".$prenom." <br/>";
                 if($pays!==null&&$adresseclient!==null&&$cpclient!==null){
                   $output.=" Adresse de résidence : ".$pays." , ".$adresseclient." , ".$cpclient." <br/>";
                 }else{
                  $output.=" Adresse de résidence : ".$py." , ".$ad." , ".$cpc." <br/>";
                 }
               
                 $output.="Email : ".$emailclient." <br/>
                 Telephone : ".$telephone." <br/>";
                 if($telephoneII != null && $telephoneII!='')
                 {
                  $output .="Telephone 2 : ".$telephoneII." <br/>";
               }
               $output .=" </td>
                </tr>

                ";

                   $output.="<tr>
                <th style='width:50%'> Information sur le payement: </th><td>
                   Service : ".$service." , ".$categorie."<br/>
                    type de recurrence : ".$rc." <br/>
                 Montant : <span class='label label-danger'> ".$montant." ".$dv." </span> <br/>
               
                les  Date du rendez vous  : ";

                    foreach ($dates as $date) {
                $output.=$date->getDatev()->format('Y-m-d')."<br/>";
               }

                 


               $output.= " 

              Date du payment : ".$datepayment." <br/>

               </td>
                </tr>

                ";

             

            
                 

                $output.="</table>
              </div>

                ";








 $response=new JsonResponse(array('output'=>$output));


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
     * @Route("/voir-compte-agent" , name="view_compte_admin")
     */
    public function viewcompteAction(Request $request)
    {

     $user = $this->container->get('security.token_storage')->getToken()->getUser();
      $entityManager = $this->getDoctrine()->getManager();
      $status='';
      $output='';

     $authchecker= $this->container->get('security.authorization_checker');
     if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_SUPER_ADMIN')))
   {
     
      if($request->isXmlHttpRequest())
                     {
       
           $id=$request->request->get('id');
      $compte=$entityManager->getRepository('FrontBundle:User')->find($id);
    
   

   



        
           $output.=" <div class='table-responsive'>
            <table class='table'>";


               
                 $output.="<tr>
                <th style='width:50%'>Raison Sociale : </th><td>
                 ".$compte->getRaison()."
                </td>
                </tr>

                ";


                  $output.="<tr>
                <th style='width:50%'>Responsable : </th><td>
                 ".$compte->getResponsable()."
                </td>
                </tr>

                ";

                   $output.="<tr>
                <th style='width:50%'>Service : </th><td>
                 ".$compte->getService()->getTitre()."
                </td>
                </tr>

                ";

                 $output.="<tr>
                <th style='width:50%'>Adresse : </th><td>
                 ".$compte->getAdresse()." ,".$compte->getCp()."
                </td>
                </tr>

                ";

               



                  $output.="<tr>
                <th style='width:50%'>Numéro SIRET : </th><td>
                 ".$compte->getTva()."
                </td>
                </tr>

                ";

$path='uploads/document/'.$compte->getFile();
$url=$this->container->get('assets.packages')->getUrl($path);

               $output.="<tr>
                <th style='width:50%'>Document de l&apos;Entreprise : </th><td>
               
                <a  href=".$this->container->get('assets.packages')->getUrl($path)." target='_blank'>Document de l&apos;entreprise </a>
                
                </td>
                </tr>";

            
                 

                $output.="</table>
              </div>

                ";








 $response=new JsonResponse(array('output'=>$output));


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
     * @Route("/activer-compte-function",name="active_compte_ajax")
     */
    public function activerajaxAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_SUPER_ADMIN')))
    {
     
       if($request->isXmlHttpRequest())
       {

          $id=$request->request->get('id');
        $agent=$em->getRepository('FrontBundle:User')->find($id);
         
         $agent->setValid(0);

       


  
    $em->persist($agent);
     $em->flush();

    
     $notification=new Notification();

     $notification->setSubject('Activation Compte');
     $text='Votre compte est activé avec success  ';
     $notification->setNotificationText($text);
     $notification->setStatus(0);
     $notification->setCreatedAt(new \DateTime());
     $notification->setUser($agent);
     $em->persist($notification);
     $em->flush();



       $msg="Compte activé avec success  !";
                $response=new JsonResponse(['success'=>true,'message'=>$msg]);

                return $response;

        }else{

              $msg="Erreur requete";
                $response=new JsonResponse(['success'=>false,'message'=>$msg]);

                return $response;

        }
      
       



     }  else{

        $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));
    }



    }





    /**
     * @Route("/inactive",name="inactive_compte")
     */
    public function inactiveajaxAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_SUPER_ADMIN')))
    {
     
       if($request->isXmlHttpRequest())
       {

          $id=$request->request->get('id');
        $agent=$em->getRepository('FrontBundle:User')->find($id);
        $email=$agent->getEmail();
         
      
     $text='Bonjour,

    Les données qui vous avez envoyé est non valides ,vous devez  envoyer a nouveau vos données valide par email pour activé votre comptes .

    cordialement.

     ';
      


    $mail = \Swift_Message::newInstance()
        ->setSubject('Activation du compte')
        ->setFrom('houssemalayet17@gmail.com')
        ->setTo($email)
        ->setBody($text);

       
    $this->get('mailer')->send($mail);


    
     $notification=new Notification();

     $notification->setSubject('Activation Compte');
     $text='Les données qui vous avez envoyé est non valides ,vous devez  envoyer a nouveau vos données valide par email pour activé votre comptes   ';
     $notification->setNotificationText($text);
     $notification->setStatus(0);
     $notification->setCreatedAt(new \DateTime());
     $notification->setUser($agent);
     $em->persist($notification);
     $em->flush();



       $msg=" Success  !";
                $response=new JsonResponse(['success'=>true,'message'=>$msg]);

                return $response;

        }else{

              $msg="Erreur requete";
                $response=new JsonResponse(['success'=>false,'message'=>$msg]);

                return $response;

        }
      
       



     }  else{

        $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));
    }



    }





































}
