<?php


namespace BackBundle\Twig\Extension;
use Doctrine\ORM\EntityManagerInterface ;


class ActivationExtension extends  \Twig_Extension
{
    protected $entityManager;
  

    public function __construct(EntityManagerInterface  $entityManager)
    {
        $this->entityManager = $entityManager;
    
    }

    public function getEtat()
    {
      
             $user = $this->container->get('security.token_storage')->getToken()->getUser();


          $etat =$user->getValid();

          



        return array (
           'etat'=>$etat
        );
    }




   /**
     * Return the functions registered as twig extensions
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('etat', array($this,'getEtat')),
        );
    }






    public function getName()
    {
        return "BackBundle:ActivationExtension";
    }
}