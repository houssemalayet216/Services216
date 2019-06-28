<?php
// src/AppBundle/Entity/User.php

namespace FrontBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="FrontBundle\Repository\UserRepository")
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;



    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255,nullable=true)
     */
    protected $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255,nullable=true)
     */
    protected $prenom;

     /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="integer", length=8,nullable=true)
     */
    protected $telephone;


    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="text",nullable=true)
     * @Assert\Image()
     */
    protected $logo;


    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255,nullable=true)
     */
    protected $adresse;

     /**
     * @var string
     *
     * @ORM\Column(name="fb", type="string", length=255,nullable=true)
     */
    protected $fb;

     /**
     * @var string
     *
     * @ORM\Column(name="skype", type="string", length=255,nullable=true)
     */
    protected $skype;

     /**
     * @var string
     *
     * @ORM\Column(name="linkedin", type="string", length=255,nullable=true)
     */
    protected $linkedin;
    /**
     * @var string
     *
     * @ORM\Column(name="valid", type="integer",nullable=true)
     */
    protected $valid;


      /**
     * @var string
     *
     * @ORM\Column(name="civilite", type="string", length=255,nullable=true)
     */
    protected $civilite;


     /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=255,nullable=true)
     */
      protected $pays;

     /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255,nullable=true)
     */
     protected $ville;

       /**
     * @var string
     *
     * @ORM\Column(name="cp", type="integer",nullable=true)
     */
     protected $cp;


      /**
     * @var string
     *
     * @ORM\Column(name="post", type="string", length=255,nullable=true)
     */
    protected $post;

      /**
     * @var string
     *
     * @ORM\Column(name="type_resident", type="string", length=255,nullable=true)
     */
     protected $residence;

    /**
     * @var string
     *
     * @ORM\Column(name="raison_sociale", type="string", length=255,nullable=true)
     */
    protected $raison;


    /**
     * @var string
     *
     * @ORM\Column(name="responsable", type="string", length=255,nullable=true)
     */
    protected $responsable;


    

    /**
     * @var string
     *
     * @ORM\Column(name="code_tva", type="string", length=255,nullable=true)
     */
   protected   $tva;

   
   /**
     * @var string
     *
     * @ORM\Column(name="file", type="string",nullable=true)
     *@Assert\File(mimeTypes={ "application/pdf" },maxSize="1074000000")
     */
   protected  $file;


    /** 
   * @ORM\ManyToOne(targetEntity="BackBundle\Entity\Service") 
   * @ORM\JoinColumn(nullable=true)
   */
   private $service;

   

    /**
     * @var integer
     *
     * @ORM\Column(name="ncompte", type="integer", nullable=true)
     */
   protected   $ncompte;



    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    
      public function getNom()
    {
        return $this->nom;
    }


  

    


      public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }



      public function getPrenom()
    {
        return $this->prenom;
    }


      public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
        return $this;
    }

    
      public function getTelephone()
    {
        return $this->telephone;
    }


      public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
        return $this;
    }  

   
     public function getLogo()
    {
        return $this->logo;
    }


      public function setLogo($logo)
    {
        $this->logo = $logo;
        return $this;
    }  


         public function getAdresse()
    {
        return $this->adresse;
    }


      public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
        return $this;
    }  


   
        public function getFb()
    {
        return $this->fb;
    }


      public function setFb($fb)
    {
        $this->fb = $fb;
        return $this;
    } 

         public function getSkype()
    {
        return $this->skype;
    }


      public function setSkype($skype)
    {
        $this->skype = $skype;
        return $this;
    } 


         public function getLinkedin()
    {
        return $this->linkedin;
    }


      public function setLinkedin($linkedin)
    {
        $this->linkedin = $linkedin;
        return $this;
    } 


           public function getValid()
    {
        return $this->valid;
    }


      public function setValid($valid)
    {
        $this->valid = $valid;
        return $this;
    } 


     public function getCivilite()
    {
        return $this->civilite;
    }


      public function setCivilite($civilite)
    {
        $this->civilite = $civilite;
        return $this;
    } 




       public function getPays()
    {
        return $this->pays;
    }


      public function setPays($pays)
    {
        $this->pays = $pays;
        return $this;
    } 

      public function getVille()
    {
        return $this->ville;
    }


      public function setVille($ville)
    {
        $this->ville = $ville;
        return $this;
    } 

       public function getCp()
    {
        return $this->cp;
    }


      public function setCp($cp)
    {
        $this->cp = $cp;
        return $this;
    }


        public function getPost()
    {
        return $this->post;
    }


      public function setPost($post)
    {
        $this->post = $post;
        return $this;
    }



 


       public function getResidence()
    {
        return $this->residence;
    }


      public function setResidence($residence)
    {
        $this->residence = $residence;
        return $this;
    } 


        public function getRaison()
    {
        return $this->raison;
    }


      public function setRaison($raison)
    {
        $this->raison = $raison;
        return $this;
    } 
     

    public function getResponsable()
    {
        return $this->responsable;
    }


      public function setResponsable($responsable)
    {
        $this->responsable = $responsable;
        return $this;
    } 


 

     

      public function getTva()
    {
        return $this->tva;
    }


      public function setTva($tva)
    {
        $this->tva = $tva;
        return $this;
    } 


    public function getFile()
    {
        return $this->file;
    }


      public function setFile($file)
    {
        $this->file = $file;
        return $this;
    } 
    

    /**
     * Set service
     *
     * @param \BackBundle\Entity\Service $service
     *
     * @return User
     */
    public function setService(\BackBundle\Entity\Service $service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return \BackBundle\Entity\Service
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set ncompte
     *
     * @param integer $ncompte
     *
     * @return User
     */
    public function setNcompte($ncompte)
    {
        $this->ncompte = $ncompte;

        return $this;
    }

    /**
     * Get ncompte
     *
     * @return integer
     */
    public function getNcompte()
    {
        return $this->ncompte;
    }
}