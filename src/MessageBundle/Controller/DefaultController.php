<?php

namespace MessageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use BackBundle\Entity\Contacter;
use BackBundle\Entity\Notification;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use BackBundle\Entity\Dates;
use BackBundle\Entity\Mission;
use BackBundle\Entity\Membre;
use BackBundle\Entity\Message;

class DefaultController extends Controller
{





     /**
     * @Route("/user/home/envoi-mail",name="envoi_mail_agent")
     */
    public function envoimailagentAction(Request $request)
    {

         $entityManager = $this->getDoctrine()->getManager();
           $user = $this->container->get('security.token_storage')->getToken()->getUser();
    
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
    {

            $message = new Message();

    $form = $this->createFormBuilder($message)
        ->add('nom', TextType::Class)
          ->add('prenom', TextType::Class) 
           ->add('adresse', TextType::Class)
            ->add('sujet', TextType::Class)
             ->add('message', TextareaType::Class)     

           ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted()) {

       if  ($form->isValid())
         {


         $message->setDatedenvoi(new \DateTime('now'));
         $message->setStatus('En attente');
          $entityManager->persist($message);


      $entityManager->flush();

          if($request->isXmlHttpRequest())
                     {

                        $msg='Message envoyer avec succèss';
                        $response=new JsonResponse(array('success'=>true,'message'=>$msg));

                     }


         }elseif($request->isXmlHttpRequest()){

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





         return $this->render('MessageBundle:Agent:message.html.twig',['form'=>$form->createView()]);




    }else{
     
      $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));
    
     }


   }








     /**
     * @Route("/user/home/mail-envoi",name="envoi_mail_client")
     */
    public function envoimailclientAction(Request $request)
    {

        $entityManager = $this->getDoctrine()->getManager();
           $user = $this->container->get('security.token_storage')->getToken()->getUser();
    
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
    {

            $message = new Message();

    $form = $this->createFormBuilder($message)
        ->add('nom', TextType::Class)
          ->add('prenom', TextType::Class) 
           ->add('adresse', TextType::Class)
            ->add('sujet', TextType::Class)
             ->add('message', TextareaType::Class)     

           ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted()) {

       if  ($form->isValid())
         {
             $message->setStatus('En attente');
            $message->setDatedenvoi(new \DateTime('now'));
          $entityManager->persist($message);


      $entityManager->flush();

          if($request->isXmlHttpRequest())
                     {

                        $msg='Message envoyer avec succèss';
                        $response=new JsonResponse(array('success'=>true,'message'=>$msg));

                     }


         }elseif($request->isXmlHttpRequest()){

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





         return $this->render('MessageBundle:Client:message.html.twig',['form'=>$form->createView()]);




    }else{
     
      $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));
    
     }



   }





    /**
     * @Route("/retour",name="retour_url")
     */
    public function retourAction(Request $request)
    {

     $referer = $request->headers->get('referer');
            return $this->redirect($referer);

    }












   
}
