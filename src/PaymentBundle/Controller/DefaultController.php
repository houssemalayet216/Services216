<?php

namespace PaymentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PaymentBundle\Aide\Stripe;
use BackBundle\Entity\Contacter;
use BackBundle\Entity\Notification;
use BackBundle\Entity\Annonce;
use BackBundle\Entity\facturation;
class DefaultController extends Controller
{
 

 /**
     * @Route("/payment-proposition",name="payment_proposition")
     */
    public function paymentpropositionAction(Request $request)
    {
        $em= $this->getDoctrine()->getManager();
      $user = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
    { 

if($request->isXmlHttpRequest()&&$request->isMethod('post'))
       {
    	
    	

    $idmission=$request->request->get('idpropositionpayment');
   $mission= $em->getRepository('BackBundle:Contacter')->find($idmission);

  	$token=$request->request->get('stripeToken');
    	$email=$request->request->get('emailpropositionpayment');
    	$name=$request->request->get('nompropositionpayment');
        

	    





$stripe=new Stripe('sk_test_6jsFvM8H5NlGHarUn4m1HXbI');
$customer=$stripe->api('customers',['source'=>$token,
 'description'=>$name,
 'email'=>$email
]);

	$ch=curl_init();
  $prixs=$mission->getPrix();
  $montant=sprintf("%d00",$prixs);
  $convmontant=intval($montant);


	$charge=$stripe->api('charges',[
    'amount'=>$convmontant,
    'currency'=>$mission->getTypetarification(),
    'customer'=>$customer->id
		
	]);

	if($charge->failure_message==null)

	{

      
     $mission->setEtat('En cours');
      $em->persist($mission);
     $em->flush();
     $annonce= $mission->getAnnonce();
     $Agent=$mission->getDemandeur();
     $prix=$mission->getPrix();
     $tr=$mission->getTypetarification();
     $facturation=new Facturation();
     $facturation->setDatepayment(new \DateTime('now'));
     $facturation->setClient($user);
     $facturation->setAgent($Agent);
     $facturation->setTarification($tr);
     $facturation->setMontant($prix);
     $facturation->setAnnonce($annonce);
     $facturation->setContacter($mission);

          $em->persist($facturation);
     $em->flush();
     $notification=new Notification();


      $text='Le Client '.$user->getNom() . ' '.$user->getPrenom().' a compléter le procédure de payement pour la service '.$annonce->getSpecialite()->getTitre() ; 
       $notification->setSubject('Payement effectué avec success');
      $notification->setNotificationText($text);
     $notification->setStatus(0);
     $notification->setCreatedAt(new \DateTime());
     $notification->setUser($Agent);
     $em->persist($notification);
     $em->flush();








        $msg="Opération complète avec success !";
                $response=new JsonResponse(['success'=>true,'message'=>$msg]);

                return $response;



	}else{

        $msg="Une Eureur se produit !!!!";
                $response=new JsonResponse(['success'=>false,'message'=>$msg]);

                return $response;


	}

       



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
     * @Route("/payment-demande",name="payment_demande")
     */
    public function paymentdemandeAction(Request $request)
    {
        $em= $this->getDoctrine()->getManager();
      $user = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
    { 

if($request->isXmlHttpRequest()&&$request->isMethod('post'))
       {
      
      

    $idmission=$request->request->get('iddemandepayment');
   $mission= $em->getRepository('BackBundle:Contacter')->find($idmission);

    $token=$request->request->get('stripeToken');
      $email=$request->request->get('emaildemandepayment');
      $name=$request->request->get('nomdemandepayment');
        

      





$stripe=new Stripe('sk_test_6jsFvM8H5NlGHarUn4m1HXbI');
$customer=$stripe->api('customers',['source'=>$token,
 'description'=>$name,
 'email'=>$email
]);

  $ch=curl_init();


   $prixs=$mission->getPrix();
  $montant=sprintf("%d00",$prixs);
  $convmontant=intval($montant);

  $charge=$stripe->api('charges',[
    'amount'=>$convmontant,
    'currency'=>$mission->getTypetarification(),
    'customer'=>$customer->id
    
  ]);

  if($charge->failure_message==null)

  {

      
     $mission->setEtat('En cours');
      $em->persist($mission);
     $em->flush();
     $annonce= $mission->getAnnonce();
     $Agent=$mission->getAnnonceur();
     $prix=$mission->getPrix();
     $tr=$mission->getTypetarification();
     $facturation=new Facturation();
     $facturation->setDatepayment(new \DateTime('now'));
     $facturation->setClient($user);
     $facturation->setAgent($Agent);
     $facturation->setTarification($tr);
     $facturation->setMontant($prix);
     $facturation->setAnnonce($annonce);
     $facturation->setContacter($mission);

          $em->persist($facturation);
     $em->flush();
     $notification=new Notification();


      $text='Le Client '.$user->getNom() . ' '.$user->getPrenom().' a compléter le procédure de payement pour la service '.$annonce->getSpecialite()->getTitre() ; 
       $notification->setSubject('Payement effectué avec success');
      $notification->setNotificationText($text);
     $notification->setStatus(0);
     $notification->setCreatedAt(new \DateTime());
     $notification->setUser($Agent);
     $em->persist($notification);
     $em->flush();








        $msg="Opération complète avec success !";
                $response=new JsonResponse(['success'=>true,'message'=>$msg]);

                return $response;



  }else{

        $msg="Une Eureur se produit !!!!";
                $response=new JsonResponse(['success'=>false,'message'=>$msg]);

                return $response;


  }

       



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
     * @Route("/prix-payment/{id}",name="prix_payement")
     */
    public function prixpaymentAction(Request $request,$id)
    {
        $em= $this->getDoctrine()->getManager();
      $user = $this->container->get('security.token_storage')->getToken()->getUser();
     
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
    { 

      if($request->isXmlHttpRequest()&&$request->isMethod('post'))
       {


   $mission= $em->getRepository('BackBundle:Contacter')->find($id);
   $prix=$mission->getPrix();
   $tarifications=$mission->getTypetarification();
   $tarification='';
if($tarifications=='eur')
{
$tarification='Euro';
}else{
$tarification='USD';
}



   $output=array('prix'=>$prix,'tarification'=>$tarification);


                $response=new JsonResponse(['success'=>true,'output'=>$output]);

                return $response;


    }else{

        $msg="Une Eureur se produit !!!!";
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
     * @Route("/facturation",name="facturation_client")
     */
    public function facturationAction(Request $request)
    {
         $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
    {

        $output=array('data'=>array());
      
    
          $factures = $em->getRepository('BackBundle:facturation')->findBy(
array('client'=>$user),
array('datepayment' => 'DESC'));
    
      foreach ($factures as $facture) {
 $id =$facture->getId();

$benificaire=$facture->getAgent()->getRaison();
$service=$facture->getAnnonce()->getService()->getTitre();
$montant=$facture->getMontant();
$devise=$facture->getTarification();

$datepayment=$facture->getDatepayment()->format('Y-m-d H:i');






$button=" <div  class='text-center'>
                    
 <a href='".$this->get('router')->generate('facturation_page_voir', array('id' => $id))."' target='_blank' ><button class='btn btn-success'>Voir</button></a>
 <a href='".$this->get('router')->generate('facturation_page_telecharger', array('id' => $id))."'  ><button class='btn btn-primary'>Télécharger</button></a>"
   ;         

 

$button.="</div>"; 


                    
                 



$output['data'][]=array(


 $benificaire,
 $service,
 $montant,
  $devise,
 $datepayment,

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
     * @Route("/user/home/facturation",name="facturation_page")
     */
    public function facturationpageAction(Request $request)
    {

     $user = $this->container->get('security.token_storage')->getToken()->getUser();
      $entityManager = $this->getDoctrine()->getManager();

     $authchecker= $this->container->get('security.authorization_checker');
     if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
   {
     
       

      
 return $this->render('PaymentBundle:Default:facturation.html.twig');

     }
   else{
  

         $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));


    
     }



}  















   /**
     * @Route("/user/home/voir-facture-{id}",name="facturation_page_voir")
     */
    public function facturationvoirAction(Request $request,$id)
    {

     $user = $this->container->get('security.token_storage')->getToken()->getUser();
      $entityManager = $this->getDoctrine()->getManager();
       $devis='';
     $authchecker= $this->container->get('security.authorization_checker');
     if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
   {
     
       
        $facture=$entityManager->getRepository('BackBundle:facturation')->find($id);
     
        $cur=$facture->getTarification();
      if($cur=='eur')
        {
         $devis='€';

        }else{
         

        $devis='$';

        }

          $snappy=$this->get("knp_snappy.pdf");
       $html=$this->renderView("PaymentBundle:default:facture.html.twig",["facture"=>$facture,"devis"=>$devis]);
       $filename="facture"; 
       return new Response(
       $snappy->getOutputFromHtml($html),
       200,
       array('Content-Type'=>'application/pdf',
        'Content-Disposition'=>'inline; filename="'.$filename.'.pdf"'

     )
       );

      
 

     }
   else{
  

         $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));


    
     }



}  






   /**
     * @Route("/user/home/telecharger-facture-{id}",name="facturation_page_telecharger")
     */
    public function facturationtelechrgerAction(Request $request,$id)
    {

     $user = $this->container->get('security.token_storage')->getToken()->getUser();
      $entityManager = $this->getDoctrine()->getManager();
      $devis='';

     $authchecker= $this->container->get('security.authorization_checker');
     if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
   {
     

         
        $facture=$entityManager->getRepository('BackBundle:facturation')->find($id);
        $cur=$facture->getTarification();
        if($cur=='eur')
        {
         $devis='€';

        }else{
         

        $devis='$';

        }

       $snappy=$this->get("knp_snappy.pdf");
       $html=$this->renderView("PaymentBundle:default:facture.html.twig",["facture"=>$facture,'devis'=>$devis]);
       $filename="facture"; 
    


       return new Response(
       $snappy->getOutputFromHtml($html),
       200,
       array('Content-Type'=>'application/pdf',
        'Content-Disposition'=>'attachment; filename="'.$filename.'.pdf"'

     )
       );

      
 

     }
   else{
  

         $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));


    
     }



}  



















































}
