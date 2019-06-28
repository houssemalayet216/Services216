<?php

namespace FilterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DefaultController extends Controller
{
 


  /**
     * @Route("/filter-{option}",name="filter_option")
     */
    public function filterbyoptionAction(Request $request,$option)
    {
             $em = $this->getDoctrine()->getManager();    
            $opt =$em->getRepository('BackBundle:Options')->findOneBy(array('titre'=>$option));
           
             $annonceo =$em->getRepository('BackBundle:Annonce')->findBy(array('specialite'=>$opt,'publier'=>true),array('datePublication' => 'DESC'));
             $annoncesparoption=$this->get('knp_paginator')->paginate(
        $annonceo,
        
        $request->query->get('page', 1),5);
             
            return $this->render('FilterBundle:Default:filter.html.twig',['opt'=>$opt,'annonceoption'=>$annoncesparoption,'annonceo'=>$annonceo]); 
    }


   /**
     * @Route("/home/filter-{service}",name="filter_service")
     */
    public function filterbyserviceAction(Request $request,$service)
    {        

             $em = $this->getDoctrine()->getManager();
               
             $ser = $em->getRepository('BackBundle:Service')->findOneBy(array('titre'=>$service));

             $options =$em->getRepository('BackBundle:Options')->findBy(array('service'=>$ser));

             $annonces =$em->getRepository('BackBundle:Annonce')->findBy(array('service'=>$ser,'publier'=>true),array('datePublication' => 'DESC'));
             
          $annoncesparservice  = $this->get('knp_paginator')->paginate(
        $annonces,
        
        $request->query->get('page', 1),5);

       
      

              
            return $this->render('FilterBundle:Default:filter.html.twig',['options'=>$options,'annonceservice'=>$annoncesparservice,'annonces'=>$annonces]); 
    }








   /**
     * @Route("/filtre",name="filter_ajax")
     */
    public function filterajaxAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
    $authchecker= $this->container->get('security.authorization_checker');
    
    $output='';
    $query='';
    $page='';
    $per_row_page=5;


     if($request->isMethod('POST')  && $request->isXmlHttpRequest())
       {
          $datenow=new \DateTime();
         $dateselectedtrue='';

          


          $dateslected=new \DateTime();
          
    
         
        $option=$request->request->get('option');
         $opt=$request->request->get('opt');
        $ville=$request->request->get('ville');
        $type_annonce=$request->request->get('type_annonce');
        $type_visite=$request->request->get('type_visite');
      

  

        if($request->request->get('page')!==null)
         {
           $page=$request->request->get('page');
         }else{
            $page=1;
         }
         





        if($request->request->get('action'))
         {

          $query.="SELECT a FROM BackBundle:Annonce a WHERE  a.publier = :publier  ";  
         } 


  /*          if($request->request->get('option')!== null && $request->request->get('opt')==null)
    {

      

      $query.="AND a.specialite = :option  ";

    }


             if($request->request->get('opt')!== null && $request->request->get('option')==null)
    {

      

      $query.="AND a.specialite = :opt  ";

    }*/ 


    if($option!==""&&$opt=="")
    {
      $query.="AND a.specialite = :option  ";
    }
    if($opt!==""&&$option==""){
       $query.="AND a.specialite = :opt  ";
    }






            if($request->request->get('ville'))
    {

      

      $query.=" AND a.zone = :ville  ";

    } 

              if($request->request->get('type_annonce'))
    {

      

      $query.=" AND a.typeAnnance = :type_annonce  ";

    }


                 if($request->request->get('type_visite'))
    {

      

      $query.=" AND a.typeVisite = :type_visite ";

    }

    if($request->request->get('datefilter')&&$request->request->get('datefilter')!== null)
        {
          $nbrday=$request->request->get('datefilter');
         $dateselectedtrue=$dateslected->modify('- '.$nbrday.' day');
        }








                    if($request->request->get('datefilter') )
    {

     

      $query.=" AND a.datePublication BETWEEN  :timeselected AND :timenow  ";

    }


   



       $start_from=($page-1) * $per_row_page ;
    
 
 $requet=$em->createQuery($query)->setParameter('publier',true);


   if($request->request->get('option')!== "" && $request->request->get('opt')=="")
   {
    $requet->setParameter('option',$option);
   }
   if($request->request->get('opt')!== "" && $request->request->get('option')==""){
    $requet->setParameter('opt',$opt);
   }






   if($ville!=null)
   {
    $requet->setParameter('ville',$ville);
   }
   if($type_annonce!=null)
   {
    $requet->setParameter('type_annonce',$type_annonce);
   }
     if($type_visite!=null)
   {
    $requet->setParameter('type_visite',$type_visite);
   }


     if($request->request->get('datefilter')&&$request->request->get('datefilter')!== null)
   {
    $requet->setParameter('timenow',$datenow->format('Y-m-d'));
    $requet->setParameter('timeselected',$dateselectedtrue->format('Y-m-d'));
   }

$total_result=$requet->getResult();

$requet->setMaxResults($per_row_page);
$requet->setFirstResult($start_from);




    $annonces = $requet->getResult(); 


        $total_row=Count($annonces);
        $total_rows=Count($total_result);

        if($total_row>0) 
        {
           
        foreach ($annonces as $annonce) {

        $output.='
                  
  


<div class="annonce">
<a href="'.$this->generateUrl("single_annonce", array("id"=>$annonce->getId())).'">
<div class="img img_annonce">';

if($annonce->getImage()!==null)
{
  $path='uploads/logo/'.$annonce->getImage();
$urlimage=$this->container->get('assets.packages')->getUrl($path);

 $output.='<img src="'.$urlimage.'" style="max-width:224px;max-height:150px;">';
}else{


 $pathi='frontFolder/images/petitannonce.jpg';
$urlimagei=$this->container->get('assets.packages')->getUrl($pathi);
 $output.='<img src="'.$urlimagei.'" style="max-width:224px;max-height:150px;">';
}

 $output.='</div>';






$output.='<div class="txtannonce">
<div class="flol" style="max-width:270px;">
<h3 style="padding:0 !important;">'.$annonce->getTitre().'


</h3>
<cite style="text-transform:capitalize"> </cite>
';
if($annonce->getTypeAnnance()=='demande')
{
$output.='<h3 class="lo">'.$annonce->getUser()->getNom().' '.$annonce->getUser()->getPrenom().'</h3>';
}else{
$output.='<h3 class="lo">'.$annonce->getUser()->getRaison().'</h3>';
}
$output.='
</div>
<div class="ergov3-priceannonce">
</div>
<div class="fin"></div>
<cite class="texte">'.$annonce->getDescription().'
</cite>
</div>

<div class="ergov3-bottomannonce ergov3-bottomannmini">
<div class="ergov3-voirann">
<div class="ergov3-rightmini ergov3-rightminianim">
<span>';
if($annonce->getTypeAnnance()=='demande')
{

$output.='(Demande)';
}else{

$output.='(Offre)';
}

$output.='</span>
</div>
<div class="fin"></div>
<span class="voirann voirannanim">Voir l&apos;annonce</span>
</div>
<div class="fin"></div>
</div>















<div class="fin"></div>

</a>  
</div>


<div class="fin"></div>



























        ';


        }










        }else{

            $output.='<h3>Aucun annonce trouver</h3>';
        }



          if($total_rows>=$per_row_page) 
    {

    $total_page=ceil($total_rows/$per_row_page);
    
   
  

     $output.=  "<div  class='col-lg-3 col-lg-offset-6'>
        <ul class='pagination'>";
         for($i=1;$i<=$total_page;$i++)
    {

        if($i==$page)
        {
         $output.="<li class='pagination_link common_li active'><a   id=".$i."'>".$i."</a></li>";   
        }else{

            $output.="<li class='pagination_link common_li'><a   id=".$i."'>".$i."</a></li>";

        }    





    }

    $output.="</ul>



       </div>";

    }








           
           
       
         
           $response=new JsonResponse($output);

                return $response;

  
       }else{
           $msg="Erreur requete";
                $response=new JsonResponse(['success'=>false,'message'=>$msg]);

                return $response;

       }

}




    /**
     * @Route("/recherche",name="recherche_annonce")
     */
    public function rechercheannonceAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $authchecker= $this->container->get('security.authorization_checker');
        $query='';
       
    /* if($request->isMethod('POST'))
       {
         */
        $mot=$request->request->get('mot_cle_front_recherche');
        $zone=$request->request->get('ville_front_recherche');
        $motcle='%'.$mot.'%';
        $option=$request->request->get('option_front_recherche');
       

        
         if($request->request->get('mot_cle_front_recherche') !== null)
         {
           $query.="SELECT a FROM BackBundle:Annonce a WHERE a.titre LIKE :motcle AND a.publier = :publier ";
         }else{
            
             $query.="SELECT a FROM BackBundle:Annonce a WHERE  a.publier = :publier  "; 
         }


   
         if($request->request->get('option_front_recherche') !== null)
         {
           $query.=" AND a.specialite = :option  ";
         }

        

           if($request->request->get('ville_front_recherche') !== null)
         {
              $query.=" AND a.zone = :ville  ";
         }
         

  /*  if($request->request->get('type_front_recherche') !== null)
    {

      

      $query.=" AND a.typeAnnance = :type  ";

    }*/

    /*  if($request->request->get('mot_cle_front_recherche') !== null)
         {
           $query.=" AND a.titre LIKE :motcle  ";
         }*/

         
          $requet=$em->createQuery($query)->setParameter('publier',true);
   if($option!==null )
   {
    $requet->setParameter('option',$option);
   }

   if($zone!==null )
   {
    $requet->setParameter('ville',$zone);
   }

    if($mot!==null )
   {
    $requet->setParameter('motcle',$motcle);
   }

  /*   if($type!==null )
   {
    $requet->setParameter('type',$type);
   }*/



     $annonces = $requet->getResult(); 
    

           
          $annoncesrecherche  = $this->get('knp_paginator')->paginate(
        $annonces,
        
        $request->query->get('page', 1),4);


              $query="SELECT o FROM BackBundle:Options o ORDER BY o.service ASC ";
      $options=$em->createQuery($query)->getResult();

          return $this->render('FilterBundle:Default:rechercher.html.twig',['options'=>$options,'annoncesrecherche'=>$annoncesrecherche,'annonces'=>$annonces]); 



 /*      }else{
          
         throw new AccessDeniedException("vous ne pouvez pas accéder a cette ressource !");

   }*/

       }







   /**
     * @Route("/recherche_service",name="filter_recherche")
     */
    public function filterrechercheAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
    $authchecker= $this->container->get('security.authorization_checker');
    
    $output='';
    $query='';
    $page='';
    $per_row_page=5;


     if($request->isMethod('POST')  && $request->isXmlHttpRequest())
       {
          $datenow=new \DateTime();
          

          


          $dateslected=new \DateTime();
          $dateselectedtrue='';
    
         
        $option=$request->request->get('option');
        $ville=$request->request->get('ville');
        $type_annonce=$request->request->get('type_annonce');
        $type_visite=$request->request->get('type_visite');
        if($request->request->get('datefilter')&&$request->request->get('datefilter')!== null)
        {
          $nbrday=$request->request->get('datefilter');
         $dateselectedtrue=$dateslected->modify('- '.$nbrday.' day');
        }


        if($request->request->get('page')!==null)
         {
           $page=$request->request->get('page');
         }else{
            $page=1;
         }
         





        if($request->request->get('action'))
         {

          $query.="SELECT a FROM BackBundle:Annonce a WHERE  a.publier = :publier  ";  
         } 


            if($request->request->get('option')!== null)
    {

      

      $query.="AND a.specialite = :option  ";

    }


 

            if($request->request->get('ville'))
    {

      

      $query.=" AND a.zone = :ville  ";

    } 

              if($request->request->get('type_annonce'))
    {

      

      $query.=" AND a.typeAnnance = :type_annonce  ";

    }


                 if($request->request->get('type_visite'))
    {

      

      $query.=" AND a.typeVisite = :type_visite ";

    }

                    if($request->request->get('datefilter') )
    {

     

      $query.=" AND a.datePublication BETWEEN  :timeselected AND :timenow  ";

    }

       $start_from=($page-1) * $per_row_page ;
    
 
 $requet=$em->createQuery($query)->setParameter('publier',true);
   if($option!==null)
   {
    $requet->setParameter('option',$option);
   }
 
   if($ville!=null)
   {
    $requet->setParameter('ville',$ville);
   }
   if($type_annonce!=null)
   {
    $requet->setParameter('type_annonce',$type_annonce);
   }
     if($type_visite!=null)
   {
    $requet->setParameter('type_visite',$type_visite);
   }


     if($request->request->get('datefilter')&&$request->request->get('datefilter')!== null)
   {
    $requet->setParameter('timenow',$datenow->format('Y-m-d'));
    $requet->setParameter('timeselected',$dateselectedtrue->format('Y-m-d'));
   }

$total_result=$requet->getResult();

$requet->setMaxResults($per_row_page);
$requet->setFirstResult($start_from);




    $annonces = $requet->getResult(); 


        $total_row=Count($annonces);
        $total_rows=Count($total_result);

        if($total_row>0) 
        {
           
        foreach ($annonces as $annonce) {

         


          $output.='
                  
  


<div class="annonce">
<a href="'.$this->generateUrl("single_annonce", array("id"=>$annonce->getId())).'">
<div class="img img_annonce">';

if($annonce->getImage()!==null)
{
  $path='uploads/logo/'.$annonce->getImage();
$urlimage=$this->container->get('assets.packages')->getUrl($path);

 $output.='<img src="'.$urlimage.'" style="max-width:224px;max-height:150px;">';
}else{


$pathi='frontFolder/images/petitannonce.jpg';
$urlimagei=$this->container->get('assets.packages')->getUrl($pathi);
 $output.='<img src="'.$urlimagei.'" style="max-width:224px;max-height:150px;">';
}

 $output.='</div>';






$output.='<div class="txtannonce">
<div class="flol" style="max-width:270px;">
<h3 style="padding:0 !important;">'.$annonce->getTitre().'


</h3>
<cite style="text-transform:capitalize"> </cite>
';
if($annonce->getTypeAnnance()=='demande')
{
$output.='<h3 class="lo">'.$annonce->getUser()->getNom().'" "'.$annonce->getUser()->getPrenom().'</h3>';
}else{
$output.='<h3 class="lo">'.$annonce->getUser()->getRaison().'</h3>';
}
$output.='
</div>
<div class="ergov3-priceannonce">
</div>
<div class="fin"></div>
<cite class="texte">'.$annonce->getDescription().'
</cite>
</div>

<div class="ergov3-bottomannonce ergov3-bottomannmini">
<div class="ergov3-voirann">
<div class="ergov3-rightmini ergov3-rightminianim">
<span>';
if($annonce->getTypeAnnance()=='demande')
{

$output.='(Demande)';
}else{

$output.='(Offre)';
}

$output.='</span>
</div>
<div class="fin"></div>
<span class="voirann voirannanim">Voir l&apos;annonce</span>
</div>
<div class="fin"></div>
</div>















<div class="fin"></div>

</a>  
</div>


<div class="fin"></div>



























        ';         
               





        }










        }else{

            $output.='<h3>Aucun annonce trouver</h3>';
        }



          if($total_rows>=$per_row_page) 
    {

    $total_page=ceil($total_rows/$per_row_page);
    
   
  

     $output.=  "<div  class='col-lg-3 col-lg-offset-6'>
        <ul class='pagination'>";
         for($i=1;$i<=$total_page;$i++)
    {

        if($i==$page)
        {
         $output.="<li class='pagination_link_recherche common_li active'><a   id=".$i."'>".$i."</a></li>";   
        }else{

            $output.="<li class='pagination_link_recherche common_li'><a   id=".$i."'>".$i."</a></li>";

        }    





    }

    $output.="</ul>



       </div>";

    }








           
           
       
         
           $response=new JsonResponse($output);

                return $response;

  
       }else{
           $msg="Erreur requete";
                $response=new JsonResponse(['success'=>false,'message'=>$msg]);

                return $response;

       }

}










 /**
     * @Route("/annonce/{id}",name="single_annonce")
     */
    public function singleannonceAction(Request $request,$id)
    {

                $em = $this->getDoctrine()->getManager();

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
    $authchecker= $this->container->get('security.authorization_checker');
    $annonce=$em->getRepository('BackBundle:Annonce')->find($id);
    $service=$annonce->getService();
     $typeannonce=$annonce->getTypeAnnance();
     $id=$annonce->getId();
      $query="SELECT a FROM BackBundle:Annonce a WHERE  a.id != :id and a.service = :service and a.typeAnnance = :typeannonce and a.publier= :publier  ";
       $requet=$em->createQuery($query)->setParameter('id',$id)->setParameter('service',$service)->setParameter('typeannonce',$typeannonce)->setParameter('publier',true)->setMaxResults(5);

     $simulaireannonce=$requet->getResult();
          
            return $this->render('FilterBundle:Default:single.html.twig',['annonce'=>$annonce,'simulaireannonce'=>$simulaireannonce,'typeannonce'=>$typeannonce]); 



    }




































}
