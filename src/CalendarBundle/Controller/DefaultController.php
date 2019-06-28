<?php

namespace CalendarBundle\Controller;

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

class DefaultController extends Controller
{
   



     /**
     * @Route("/user/home/calendrier",name="view_calendar")
     */
    public function viewcalendarAction(Request $request)
    {

         
           $user = $this->container->get('security.token_storage')->getToken()->getUser();
    
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
    {

         return $this->render('CalendarBundle:Default:calendar.html.twig');




    }else{
     
      $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));
    
     }


   }


      /**
     * @Route("/user/home/event-calendrier",name="event_calendar")
     */
    public function eventcalendarAction(Request $request)
    {

          $em = $this->getDoctrine()->getManager();
           $user = $this->container->get('security.token_storage')->getToken()->getUser();

           $data = array();
    
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
    {
        
      $query="SELECT c FROM BackBundle:Contacter c WHERE  c.etat = :etat AND (c.demandeur = :demandeur OR c.Annonceur = :annonceur )  "; 

 $events=$em->createQuery($query)->setParameter('etat','En cours')->setParameter('demandeur',$user)->setParameter('annonceur',$user)->getResult();
 



    /*  $events=$em->getRepository('BackBundle:Contacter')->findBy(array('etat'=>'En cours',),array('id'=>'DESC'));*/

      foreach ($events as $event ) {
       

       if($event->getType('contacter_offre'))
       {

         $dates=$event->getDates();

               foreach( $dates as $date)
        {

            $start=$date->getDatev();
            $time=$event->getTempVisite();
            $st=$start->format('Y-m-d');
            $ti=$time->format('H:i:s');
            
            $start_date_time=$st." ".$ti;
             // $start_string=strtotime($start_date_time);

             $start_date_time =\DateTime::createFromFormat('Y-m-d H:i:s',$start_date_time);
              $strrr=$start_date_time->format('Y-m-d H:i:s');
           
            $enddate=$start_date_time->modify('+2 hour');


            $end_date=$enddate->format('Y-m-d H:i:s');
      

          if($event->getAnnonce()->getSpecialite()->getTitre()!==null&&$event->getAnnonce()->getSpecialite()->getTitre()!== '')
            {
            $categorie=$event->getAnnonce()->getSpecialite()->getTitre();
            $title='Mission de '.$categorie;
            }else{
              $title='Mission dachat';
            }
            
            $data[]=array(
'id'=>$event->getId(),
'title'=>$title,
'start'=>$strrr,
'end'=>$end_date,

);




        }





       }

       if($event->getType('contacter_demande'))
       {
         
         $dates=$event->getAnnonce()->getDates();


              foreach( $dates as $date)
        {

            $start=$date->getDatev();
            $time=$event->getAnnonce()->getDatePrevu();
            $st=$start->format('Y-m-d');
            $ti=$time->format('H:i:s');
            
            $start_date_time=$st." ".$ti;
             // $start_string=strtotime($start_date_time);

             $start_date_time =\DateTime::createFromFormat('Y-m-d H:i:s',$start_date_time);
              $strrr=$start_date_time->format('Y-m-d H:i:s');
           
            $enddate=$start_date_time->modify('+2 hour');


            $end_date=$enddate->format('Y-m-d H:i:s');
      

          if($event->getAnnonce()->getSpecialite()!==null&&$event->getAnnonce()->getSpecialite()!== '')
            {
            $categorie=$event->getAnnonce()->getSpecialite()->getTitre();
            $title='Mission de '.$categorie;
            }else{
              $title='Mission dachat';
            }
            
            $data[]=array(
'id'=>$event->getId(),
'title'=>$title,
'start'=>$strrr,
'end'=>$end_date,

);




        }
























       }


      
        
  


           
                      

      
      }
    

  $response=new JsonResponse($data);
  return $response;	

    }else{
     
      $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));
    
     }


   }






  /**
     * @Route("/user/home/view-calendar",name="view_mission_calendar")
     */
    public function viewmissioncalendarAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
    {
     

    $output='';

     
     if($request->isXmlHttpRequest())
       {

        $id=$request->request->get('id');
        $start=$request->request->get('start');   
     
      
      $contacter=$em->getRepository('BackBundle:Contacter')->find($id);

     $output.=" <div class='table-responsive'>
            <table class='table'>";


       if($contacter->getType()=='contacter_offre')
       {

      $titre=$contacter->getTitre();
      $description=$contacter->getDescription();
      $prix=$contacter->getPrix();
      $etat=$contacter->getEtat();
      $datepublication=$contacter->getDatePublication()->format('Y-m-d H:i:s');
      $autres=$contacter->getAutres();
       $offre=$contacter->getAnnonce()->getTitre();
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
       $status='';
       $tarification=$contacter->getTypetarification();

      



                  $output.=" <tr>
                <th style='width:50%'>Titre </th>
                <td >".$titre." </td></tr>

                <tr>
                <th style='width:50%'>Description </th>
                <td >".$description." </td></tr>
              
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
















              


                 $output.="<tr>
                <th style='width:50%'>Cordonnées du demandeur : </th>
                <td >Télephone: ".$telephone."<br/>
                Email : ".$email."<br/>
                Pays : ".$ville."<br/>
                Adresse : ".$adresse."<br/>
                Cp : ".$cp."<br/>
                </td>
                </tr>

                ";







    $output.="<tr>
                <th style='width:50%'> Date </th>
                <td id='datemission'>".$start."</td></tr>";

       
      

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


                  
                   $output.="<br/><br/>";

                
                }



           

        }

        if($contacter->getType()=='contacter_demande')
        {



       
          $demande=$contacter->getAnnonce()->getTitre();
        $description=$contacter->getAnnonce()->getDescription();
        $autres=$contacter->getAnnonce()->getAutres();
         $depart=$contacter->getAnnonce()->getDepart();
       $arrive=$contacter->getAnnonce()->getArrive();
       $trajet=$contacter->getAnnonce()->getTrajet();
        $membres=$contacter->getAnnonce()->getMembres();
       $missions=$contacter->getAnnonce()->getMission();
       $currentadresse=$contacter->getAnnonce()->getAdressmembre();
        $listeachat=$contacter->getAnnonce()->getProduits();
        
       

    
       
       $aporter=$contacter->getAnnonce()->getAport();
       $acheter=$contacter->getAnnonce()->getAchat();
     
       
       $telephone=$contacter->getAnnonce()->getTelephone();
       $telephoneII=$contacter->getAnnonce()->getTelephoneII();
       $fix=$contacter->getAnnonce()->getFix();
       $ville=$contacter->getAnnonce()->getVille();
       $adresse=$contacter->getAnnonce()->getAdresse();
       $cp=$contacter->getAnnonce()->getCp();
       $email=$contacter->getAnnonce()->getEmail();
   
     
 
      
       

      



                $output.="<tr>
                <th style='width:50%'> Titre du Demande : </th>
                <td >".$demande." </td></tr>
              
                ";

                 
               


                 $output.=" <tr>
                <th style='width:50%'>Description du demande </th>
                <td >".$description." </td></tr>";



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






                 $output.="<tr>
                <th style='width:50%'>Cordonnées du demandeur : </th>
                <td >Télephone: ".$telephone."<br/>
                Email : ".$email."<br/>
                Pays : ".$ville."<br/>
                Adresse : ".$adresse."<br/>
                Cp : ".$cp."<br/>
                </td>
                </tr>

                ";

                


      


    $output.="<tr>
                <th style='width:50%'> Date </th>
                <td id='datemission'>".$start."</td></tr>";

       
      

     if(''!== $depart && null !== $depart&& $currentadresse== null)
      {
        
          
           $output.="<tr>
                <th style='width:50%'>Départ </th>
                <td >".$depart." </td></tr>";


      }



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


                  
                   $output.="<br/><br/>";

                
                }





















         







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













































































}
