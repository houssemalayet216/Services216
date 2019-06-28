<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use BackBundle\Entity\Notification;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\Query\ResultSetMapping;
use PDO;


class DefaultController extends Controller
{
  

    /**
     * @Route("/user/home/espace" , name="espacepage")
     */
    public function homeAction(Request $request)
    {
       $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $authchecker= $this->container->get('security.authorization_checker');

        $em=$this->getDoctrine()->getManager();
        $chart_data='';


    if((is_object($user) || $user instanceof UserInterface) &&($authchecker->isGranted('ROLE_CLIENT')))
        {


          $annoncespublier=$em->getRepository('BackBundle:Annonce')->findBy(array('user'=>$user,'typeAnnance'=>'demande'));
        $annonces=count($annoncespublier);

$demandesenvoyer=$em->getRepository('BackBundle:Contacter')->findBy(array('demandeur'=>$user,'type'=>'contacter_offre'));

$demandes=count($demandesenvoyer);
$propositionsreçus=$em->getRepository('BackBundle:Contacter')->findBy(array('Annonceur'=>$user,'type'=>'contacter_demande'));

$propositions=count($propositionsreçus);
$payments=$em->getRepository('BackBundle:facturation')->findBy(array('client'=>$user),array('datepayment'=>'DESC'),5);

           return $this->render('BackBundle:Client:content.html.twig',['annonces'=>$annonces,'propositions'=>$propositions,'demandes'=>$demandes,'payments'=>$payments]);   
        }
        
         elseif((is_object($user) || $user instanceof UserInterface)&&($authchecker->isGranted('ROLE_FOURNISSEUR')))
        {

            if($user->getValid()==1)
             {
                
                $notification=new Notification();
       
     
     $notification->setSubject('Activation Compte');
     $text='Votre compte n&apos;est pas encore active,nous vérifions vos informations est activé votre compte   . ';
     $notification->setNotificationText($text);
     $notification->setStatus(0);
     $notification->setCreatedAt(new \DateTime());
     $notification->setUser($user);
     $em->persist($notification);
     $em->flush();

             }





$user_id=$user->getId();


  $sql = " 
     
  select MONTHNAME(d.datev) AS mois ,count(*) AS nbr from dates_contacter dc,contacter c,dates d where d.id=dc.dates_id and dc.contacter_id=c.id and c.etat='En cours' group by mois";



   
    $stmt = $em->getConnection()->prepare($sql);
    $stmt->execute();
   $missions=$stmt->fetchAll(PDO::FETCH_ASSOC);


  foreach ($missions as $row) {

    $chart_data.="{mois:".$row["mois"].",nbrmissions:".$row["nbr"]." } , ";
  
   }


$chart_data=substr($chart_data,0,-2);
 












$annoncespublier=$em->getRepository('BackBundle:Annonce')->findBy(array('user'=>$user,'typeAnnance'=>'offre'));
$annonces=count($annoncespublier);

$propositionsenvoyer=$em->getRepository('BackBundle:Contacter')->findBy(array('demandeur'=>$user,'type'=>'contacter_demande'));
$propositions=count($propositionsenvoyer);

$demandesreçus=$em->getRepository('BackBundle:Contacter')->findBy(array('Annonceur'=>$user,'type'=>'contacter_offre'));
$demandes=count($demandesreçus);




$paymentsa=$em->getRepository('BackBundle:facturation')->findBy(array('Agent'=>$user),array('datepayment'=>'DESC'),5);







           return $this->render('BackBundle:Fournisseur:content.html.twig',['annonces'=>$annonces,'propositions'=>$propositions,'demandes'=>$demandes,'chart_data'=>$chart_data,'payments'=>$paymentsa]);   
        }
        else{

            return $this->redirectToRoute('frontpage');  

        }

    }

    /**
     * @Route("/" , name="frontpage")
     */
    public function indexAction(Request $request)
    {


           $em=$this->getDoctrine()->getManager();
     

       $user = $this->container->get('security.token_storage')->getToken()->getUser();
          
    if (is_object($user) || $user instanceof UserInterface) {
        
      return $this->redirectToRoute('redirect_user');
        
     }

        



    

        return $this->render('@Front/Default/content.html.twig');
    }




    
     /**
     * @Route("/user/home" ,name="redirect_user")
     */
    public function redirectionAction(Request $request)
    {
         $user = $this->container->get('security.token_storage')->getToken()->getUser();
    	$authchecker= $this->container->get('security.authorization_checker');
    	
         
   $reffer=$this->get('session')->get('referer');
   $param=$this->get('session')->get('param');


    if((is_object($user) || $user instanceof UserInterface) &&($authchecker->isGranted('ROLE_SUPER_ADMIN')))
    {
      
      /* return $this->render('@Admin/Default/espaceadmin.html.twig');*/

       return $this->redirectToRoute('tableau_de_bord');

    }else{


        if(($reffer !== null&&$reffer!=='')&&($param!==null && $param !=='')  )
   {
  
   
     $this->get('session')->set('referer','');
       $this->get('session')->set('param','');
 return $this->redirectToRoute($reffer,array('id'=>$param));

 }
 elseif(($reffer !== null&&$reffer!=='')&&($param==null || $param =='')  ){
if($reffer=="frontpage")
 {


  return $this->render('@Front/Default/content.html.twig');

 }else{
 /*  return $this->redirectToRoute($route['_route']); */ 
    $this->get('session')->set('referer','');
 return $this->redirectToRoute($reffer);
 }   


 }


else{
 
  return $this->render('@Front/Default/content.html.twig');
}



   















    }



  



     

   

    }

































}
