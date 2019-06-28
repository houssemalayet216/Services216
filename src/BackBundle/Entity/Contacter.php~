<?php

namespace BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Contacter
 *
 * @ORM\Table(name="contacter")
 * @ORM\Entity(repositoryClass="BackBundle\Repository\ContacterRepository")
 */
class Contacter
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;



        /**
     * @var string
     *
     * @ORM\Column(name="typetarification", type="string", length=255,nullable=true)
     */
    private $typetarification;



    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255,nullable=true)
     */
    private $email;


     /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255,nullable=true)
     */
    private $adresse;



     /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255,nullable=true)
     */
    private $ville;

    
       /**
     * @var string
     *
     * @ORM\Column(name="cp", type="integer",nullable=true)
     */
    private $cp;



      /**
     * @var integer
     *
     * @ORM\Column(name="telephone", type="integer",nullable=true)
     */
    private $telephone;



      /**
     * @var integer
     *
     * @ORM\Column(name="telephoneII", type="integer",nullable=true)
     */
    private $telephoneII;


    
      /**
     * @var integer
     *
     * @ORM\Column(name="fix", type="integer",nullable=true)
     */
    private $fix;



    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255,nullable=true)
     */
    private $etat;


     /**
     * @var string
     *
     * @ORM\Column(name="autres", type="string", length=255,nullable=true)
     */
    private $autres;


      /**
     * @var string
     *
     * @ORM\Column(name="exception", type="string", length=255,nullable=true)
     */
    private $exception;




    /**
     * @var datetime
     *
     * @ORM\Column(name="datePublication", type="datetime")
     */
    private $datePublication;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float",nullable=true)
     */
    private $prix;


     /**
     * @var boolean
     *
     * @ORM\Column(name="acceptecontacter", type="boolean",nullable=true)
     */
    private $acceptecontacter;


    /**
     * @var boolean
     *
     * @ORM\Column(name="coordonneescomptes", type="boolean",nullable=true)
     */
    private $coordonneescomptes;


      /**
     * @var boolean
     *
     * @ORM\Column(name="adressemembre", type="boolean",nullable=true)
     */
    private $adressemembre;



       /**
     * @var boolean
     *
     * @ORM\Column(name="aport", type="boolean",nullable=true)
     */
    private $aport;


    /**
     * @var boolean
     *
     * @ORM\Column(name="achat", type="boolean",nullable=true)
     */
    private $achat;


      /**
     * @var string
     *
     * @ORM\Column(name="trajet", type="string", length=255,nullable=true)
     */
    private $trajet;

      /**
     * @var string
     *
     * @ORM\Column(name="recurrence", type="string", length=255,nullable=true)
     */
    private $recurrence;


       /**
     * @var string
     *
     * @ORM\Column(name="listeachat", type="string", length=255,nullable=true)
     */
    private $listeachat;


       /**
     * @var string
     *
     * @ORM\Column(name="depart", type="string", length=255,nullable=true)
     */
    private $depart;



         /**
     * @var string
     *
     * @ORM\Column(name="arrive", type="string", length=255,nullable=true)
     */
    private $arrive;




     /** 
   * @ORM\ManyToOne(targetEntity="BackBundle\Entity\Annonce") 
   * @ORM\JoinColumn(nullable=true)
   */
   private $annonce;

    /** 
   * @ORM\ManyToOne(targetEntity="FrontBundle\Entity\User") 
   * @ORM\JoinColumn(nullable=true)
   */
   private $demandeur;



     /** 
   * @ORM\ManyToOne(targetEntity="FrontBundle\Entity\User") 
   * @ORM\JoinColumn(nullable=true)
   */
   private $Annonceur;



     /**
     * Many Users have Many Groups.
     * @ORM\ManyToMany(targetEntity="Dates",cascade={"persist", "remove"})
     * @ORM\JoinTable(name="dates_contacter")
     */
   private $dates;



     /**
     * @var \DateTime
     *
     * @ORM\Column(name="tempVisite", type="time",nullable=true)
     */
    private $tempVisite;




      /**
     * Many Users have Many Groups.
     * @ORM\ManyToMany(targetEntity="Membre")
     * @ORM\JoinTable(name="membre_contacter")
     */
   private $membres;


      /**
     * Many Users have Many Groups.
     * @ORM\ManyToMany(targetEntity="Mission")
     * @ORM\JoinTable(name="mission_contacter")
     */
   private $mission;



  /**
     * @var integer
     *
     * @ORM\Column(name="evaluez", type="integer",nullable=true)
     */
    private $evaluez;




   public function __construct()
{
    $this->membres = new ArrayCollection();
   
     $this->dates = new ArrayCollection();
     $this->mission = new ArrayCollection();
}




    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Contacter
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Contacter
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Contacter
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set etat
     *
     * @param string $etat
     *
     * @return Contacter
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set annonce
     *
     * @param \BackBundle\Entity\Annonce $annonce
     *
     * @return Contacter
     */
    public function setAnnonce(\BackBundle\Entity\Annonce $annonce = null)
    {
        $this->annonce = $annonce;

        return $this;
    }

    /**
     * Get annonce
     *
     * @return \BackBundle\Entity\Annonce
     */
    public function getAnnonce()
    {
        return $this->annonce;
    }

    /**
     * Set demandeur
     *
     * @param \FrontBundle\Entity\User $demandeur
     *
     * @return Contacter
     */
    public function setDemandeur(\FrontBundle\Entity\User $demandeur = null)
    {
        $this->demandeur = $demandeur;

        return $this;
    }

    /**
     * Get demandeur
     *
     * @return \FrontBundle\Entity\User
     */
    public function getDemandeur()
    {
        return $this->demandeur;
    }

    /**
     * Set annonceur
     *
     * @param \FrontBundle\Entity\User $annonceur
     *
     * @return Contacter
     */
    public function setAnnonceur(\FrontBundle\Entity\User $annonceur = null)
    {
        $this->Annonceur = $annonceur;

        return $this;
    }

    /**
     * Get annonceur
     *
     * @return \FrontBundle\Entity\User
     */
    public function getAnnonceur()
    {
        return $this->Annonceur;
    }

    /**
     * Set autres
     *
     * @param string $autres
     *
     * @return Contacter
     */
    public function setAutres($autres)
    {
        $this->autres = $autres;

        return $this;
    }

    /**
     * Get autres
     *
     * @return string
     */
    public function getAutres()
    {
        return $this->autres;
    }

  

    

    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return Contacter
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set datePublication
     *
     * @param \DateTime $datePublication
     *
     * @return Contacter
     */
    public function setDatePublication($datePublication)
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    /**
     * Get datePublication
     *
     * @return \DateTime
     */
    public function getDatePublication()
    {
        return $this->datePublication;
    }

    /**
     * Set exception
     *
     * @param string $exception
     *
     * @return Contacter
     */
    public function setException($exception)
    {
        $this->exception = $exception;

        return $this;
    }

    /**
     * Get exception
     *
     * @return string
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Contacter
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set telephone
     *
     * @param integer $telephone
     *
     * @return Contacter
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return integer
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set fix
     *
     * @param integer $fix
     *
     * @return Contacter
     */
    public function setFix($fix)
    {
        $this->fix = $fix;

        return $this;
    }

    /**
     * Get fix
     *
     * @return integer
     */
    public function getFix()
    {
        return $this->fix;
    }

    /**
     * Set acceptecontacter
     *
     * @param boolean $acceptecontacter
     *
     * @return Contacter
     */
    public function setAcceptecontacter($acceptecontacter)
    {
        $this->acceptecontacter = $acceptecontacter;

        return $this;
    }

    /**
     * Get acceptecontacter
     *
     * @return boolean
     */
    public function getAcceptecontacter()
    {
        return $this->acceptecontacter;
    }

    /**
     * Set coordonneescomptes
     *
     * @param boolean $coordonneescomptes
     *
     * @return Contacter
     */
    public function setCoordonneescomptes($coordonneescomptes)
    {
        $this->coordonneescomptes = $coordonneescomptes;

        return $this;
    }

    /**
     * Get coordonneescomptes
     *
     * @return boolean
     */
    public function getCoordonneescomptes()
    {
        return $this->coordonneescomptes;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Contacter
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Contacter
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set cp
     *
     * @param integer $cp
     *
     * @return Contacter
     */
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp
     *
     * @return integer
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Set telephoneII
     *
     * @param integer $telephoneII
     *
     * @return Contacter
     */
    public function setTelephoneII($telephoneII)
    {
        $this->telephoneII = $telephoneII;

        return $this;
    }

    /**
     * Get telephoneII
     *
     * @return integer
     */
    public function getTelephoneII()
    {
        return $this->telephoneII;
    }

    /**
     * Set adressemembre
     *
     * @param boolean $adressemembre
     *
     * @return Contacter
     */
    public function setAdressemembre($adressemembre)
    {
        $this->adressemembre = $adressemembre;

        return $this;
    }

    /**
     * Get adressemembre
     *
     * @return boolean
     */
    public function getAdressemembre()
    {
        return $this->adressemembre;
    }

    /**
     * Set aport
     *
     * @param boolean $aport
     *
     * @return Contacter
     */
    public function setAport($aport)
    {
        $this->aport = $aport;

        return $this;
    }

    /**
     * Get aport
     *
     * @return boolean
     */
    public function getAport()
    {
        return $this->aport;
    }

    /**
     * Set achat
     *
     * @param boolean $achat
     *
     * @return Contacter
     */
    public function setAchat($achat)
    {
        $this->achat = $achat;

        return $this;
    }

    /**
     * Get achat
     *
     * @return boolean
     */
    public function getAchat()
    {
        return $this->achat;
    }

    /**
     * Set trajet
     *
     * @param string $trajet
     *
     * @return Contacter
     */
    public function setTrajet($trajet)
    {
        $this->trajet = $trajet;

        return $this;
    }

    /**
     * Get trajet
     *
     * @return string
     */
    public function getTrajet()
    {
        return $this->trajet;
    }

    /**
     * Set recurrence
     *
     * @param string $recurrence
     *
     * @return Contacter
     */
    public function setRecurrence($recurrence)
    {
        $this->recurrence = $recurrence;

        return $this;
    }

    /**
     * Get recurrence
     *
     * @return string
     */
    public function getRecurrence()
    {
        return $this->recurrence;
    }

    /**
     * Set listeachat
     *
     * @param string $listeachat
     *
     * @return Contacter
     */
    public function setListeachat($listeachat)
    {
        $this->listeachat = $listeachat;

        return $this;
    }

    /**
     * Get listeachat
     *
     * @return string
     */
    public function getListeachat()
    {
        return $this->listeachat;
    }

    /**
     * Set depart
     *
     * @param string $depart
     *
     * @return Contacter
     */
    public function setDepart($depart)
    {
        $this->depart = $depart;

        return $this;
    }

    /**
     * Get depart
     *
     * @return string
     */
    public function getDepart()
    {
        return $this->depart;
    }

    /**
     * Set arrive
     *
     * @param string $arrive
     *
     * @return Contacter
     */
    public function setArrive($arrive)
    {
        $this->arrive = $arrive;

        return $this;
    }

    /**
     * Get arrive
     *
     * @return string
     */
    public function getArrive()
    {
        return $this->arrive;
    }

    /**
     * Set tempVisite
     *
     * @param \DateTime $tempVisite
     *
     * @return Contacter
     */
    public function setTempVisite($tempVisite)
    {
        $this->tempVisite = $tempVisite;

        return $this;
    }

    /**
     * Get tempVisite
     *
     * @return \DateTime
     */
    public function getTempVisite()
    {
        return $this->tempVisite;
    }

    /**
     * Add date
     *
     * @param \BackBundle\Entity\Dates $date
     *
     * @return Contacter
     */
    public function addDate(\BackBundle\Entity\Dates $date)
    {
        $this->dates[] = $date;

        return $this;
    }

    /**
     * Remove date
     *
     * @param \BackBundle\Entity\Dates $date
     */
    public function removeDate(\BackBundle\Entity\Dates $date)
    {
        $this->dates->removeElement($date);
    }

    /**
     * Get dates
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDates()
    {
        return $this->dates;
    }

    /**
     * Add membre
     *
     * @param \BackBundle\Entity\Membre $membre
     *
     * @return Contacter
     */
    public function addMembre(\BackBundle\Entity\Membre $membre)
    {
        $this->membres[] = $membre;

        return $this;
    }

    /**
     * Remove membre
     *
     * @param \BackBundle\Entity\Membre $membre
     */
    public function removeMembre(\BackBundle\Entity\Membre $membre)
    {
        $this->membres->removeElement($membre);
    }

    /**
     * Get membres
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMembres()
    {
        return $this->membres;
    }

    /**
     * Add mission
     *
     * @param \BackBundle\Entity\Mission $mission
     *
     * @return Contacter
     */
    public function addMission(\BackBundle\Entity\Mission $mission)
    {
        $this->mission[] = $mission;

        return $this;
    }

    /**
     * Remove mission
     *
     * @param \BackBundle\Entity\Mission $mission
     */
    public function removeMission(\BackBundle\Entity\Mission $mission)
    {
        $this->mission->removeElement($mission);
    }

    /**
     * Get mission
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMission()
    {
        return $this->mission;
    }

    /**
     * Set typetarification
     *
     * @param string $typetarification
     *
     * @return Contacter
     */
    public function setTypetarification($typetarification)
    {
        $this->typetarification = $typetarification;

        return $this;
    }

    /**
     * Get typetarification
     *
     * @return string
     */
    public function getTypetarification()
    {
        return $this->typetarification;
    }

    /**
     * Set evaluez
     *
     * @param integer $evaluez
     *
     * @return Contacter
     */
    public function setEvaluez($evaluez)
    {
        $this->evaluez = $evaluez;

        return $this;
    }

    /**
     * Get evaluez
     *
     * @return integer
     */
    public function getEvaluez()
    {
        return $this->evaluez;
    }
}
