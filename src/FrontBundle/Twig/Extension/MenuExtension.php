<?php


namespace FrontBundle\Twig\Extension;
use Doctrine\ORM\EntityManagerInterface ;


class MenuExtension extends  \Twig_Extension
{
    protected $entityManager;
  

    public function __construct(EntityManagerInterface  $entityManager)
    {
        $this->entityManager = $entityManager;
    
    }

    public function getMenu()
    {
      


          $servicetransport =$this->entityManager->getRepository('BackBundle:Service')->find(4);
          $servicesante = $this->entityManager->getRepository('BackBundle:Service')->find(1);
          $servicemenage = $this->entityManager->getRepository('BackBundle:Service')->find(2);
          $servicebricolage = $this->entityManager->getRepository('BackBundle:Service')->find(5);

          $transports=$this->entityManager->getRepository('BackBundle:Options')->findBy(array('service'=>$servicetransport));
          $santes=$this->entityManager->getRepository('BackBundle:Options')->findBy(array('service'=>$servicesante));
          $menages=$this->entityManager->getRepository('BackBundle:Options')->findBy(array('service'=>$servicemenage));
          $bricolages=$this->entityManager->getRepository('BackBundle:Options')->findBy(array('service'=>$servicebricolage));

          $offres = $this->entityManager->getRepository('BackBundle:Annonce')->findBy(array('typeAnnance'=>'offre','publier'=>true),array('id'=>'DESC'),5);

            $demandes = $this->entityManager->getRepository('BackBundle:Annonce')->findBy(array('typeAnnance'=>'demande','publier'=>true),array('id'=>'DESC'),5);
          





          $query="SELECT o FROM BackBundle:Options o ORDER BY o.service ASC ";
      $optionsrecherches=$this->entityManager->createQuery($query)->getResult();



        return array (
           'Transports'=>$transports,'santes'=> $santes,'menages'=>$menages,'bricolages'=>$bricolages,'optionsrecherches'=>$optionsrecherches,'offres'=>$offres,'demandes'=>$demandes
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
            new \Twig_SimpleFunction('menu', array($this,'getMenu')),
        );
    }






    public function getName()
    {
        return "RMSBundle:MenuExtension";
    }
}