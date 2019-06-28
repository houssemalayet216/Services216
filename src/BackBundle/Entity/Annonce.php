<?php

namespace BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Annonce
 *
 * @ORM\Table(name="annonce")
 * @ORM\Entity(repositoryClass="BackBundle\Repository\AnnonceRepository")
 */
class Annonce
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
     * @Assert\NotBlank(message = "Ce champ est obligatoire.")
     *
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     * @Assert\NotBlank(message = "Ce champ est obligatoire.")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255,nullable=true)
     */
    private $image;


     /**
     * @var string
     *
     * @ORM\Column(name="portfolio", type="string", length=255,nullable=true)
     */
    private $portfolio;

 

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float",nullable=true)
     * @Assert\Type(
     *     type="numeric",
     *     message="Le valeur doit etre numérique !")
     */
    private $prix;


  
     /**
     * @var string
     *
     * @ORM\Column(name="typetarif", type="string", length=255,nullable=true)
     *
     */
    private $typetarif;

     /**
     * @var boolean
     *
     * @ORM\Column(name="cordaffiche", type="boolean",nullable=true)
     *
     */
   private $cordaffiche;

     /**
     * @var boolean
     *
     * @ORM\Column(name="achat", type="boolean",nullable=true)
     *
     */
   private $achat;


     /**
     * @var boolean
     *
     * @ORM\Column(name="aport", type="boolean",nullable=true)
     *
     */
   private $aport;





    /**
     * @var string
     *
     * @ORM\Column(name="horaire", type="string", length=255,nullable=true)
     *
     */
    private $horaire;



      /**
     * @var string
     *
     * @ORM\Column(name="type_horaire", type="string", length=255,nullable=true)
     *
     */
    private $typeHoraire;



      /**
     * @var string
     *
     * @ORM\Column(name="depart", type="string", length=255,nullable=true)
     *
     */
    private $depart;


    


     /**
     * @var string
     *
     * @ORM\Column(name="arrive", type="string", length=255,nullable=true)
     *
     */
    private $arrive;



    
      /**
     * @var string
     *
     * @ORM\Column(name="place", type="string", length=255,nullable=true)
     *
     */
    private $place;



    /**
     * @var string
     *
     * @ORM\Column(name="produits", type="string", length=255,nullable=true)
     *
     */
    private $produits;

     

     /**
     * @var boolean
     *
     * @ORM\Column(name="adressmembre", type="boolean",nullable=true)
     *
     */
    private $adressmembre;



     /**
     * @var boolean
     *
     * @ORM\Column(name="trajet", type="boolean",nullable=true)
     *
     */
    private $trajet;



    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255,nullable=true)
     * 
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255,nullable=true)
     * 
     */
    private $adresse;

    /**
     * @var int
     *
     * @ORM\Column(name="cp", type="integer",nullable=true)
     * 
     * @Assert\Type(
     *     type="numeric",
     *     message="Le valeur doit etre numérique !")
     */
    private $cp;


    
      /**
     * @var string
     *
     * @ORM\Column(name="zone", type="string",length=255,nullable=true)
     */
    private $zone;





    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_publication", type="date")
     */
    private $datePublication;




     /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_visite", type="date",nullable=true)
     */
    private $dateVisite;

  
    /**
     * @var string
     *
     * @ORM\Column(name="secteur", type="string", length=255,nullable=true)
     */
    private $secteur;

       /**
     * @var string
     *
     * @ORM\Column(name="option", type="string", length=255,nullable=true)
     */
    private $option;
    


  
       /**
     * @var string
     *
     * @ORM\Column(name="conditions", type="string", length=255,nullable=true)
     */
    private $conditions;


     
     /**
     * @var string
     *
     * @ORM\Column(name="specification", type="string",length=255,nullable=true)
     */
    private $specification;


      /**
     * @var string
     *
     * @ORM\Column(name="avantages", type="string",length=255,nullable=true)
     */
    private $avantages;

 



    /**
     * @var bool
     *
     * @ORM\Column(name="publier", type="boolean",nullable=true)
     * 
     */
    private $publier;

    /**
     * @var string
     *
     * @ORM\Column(name="type_annance", type="string", length=255)
     */
    private $typeAnnance;


   /**
     * @var string
     *
     * @ORM\Column(name="type_visite", type="string", length=255,nullable=true)
     */
    private $typeVisite;



    /**
     * @var integer
     *
     * @ORM\Column(name="nbr_intervention",type="integer", nullable=true)
     */
    private $nbrIntervention;



      /**
     * @var integer
     *
     * @ORM\Column(name="nbr_membres",type="integer", nullable=true)
     */
    private $nbrmembres;



    /**
     * @var integer
     *
     * @ORM\Column(name="nbr_semaine",type="integer", nullable=true)
     */
    private $nbrsemaine;

   

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_prevu", type="time",nullable=true)
     */
    private $datePrevu;

    /**
     * @var string
     *
     * @ORM\Column(name="autres", type="string", length=255,nullable=true)
     */
    private $autres;

     /**
     * @var integer
     *
     * @ORM\Column(name="telephone", type="integer", nullable=true)
     */
    private $telephone;
     /**
     * @var integer
     *
     * @ORM\Column(name="fix", type="integer",nullable=true)
     */
    private $fix;

        /**
     * @var integer
     *
     * @ORM\Column(name="telephoneII", type="integer", nullable=true)
     */
    private $telephoneII;
     /**
     * @var string
     *
     * @ORM\Column(name="email", type="string",length=255,nullable=true)
     */
    private $email;



     /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="string", length=255,nullable=true)
     */
    private $facebook;
     /**
     * @var string
     *
     * @ORM\Column(name="linkedin", type="string", length=255,nullable=true)
     */
    private $linkedin;
     /**
     * @var string
     *
     * @ORM\Column(name="twitter", type="string", length=255,nullable=true)
     */
    private $twitter;



    
   /** 
   * @ORM\ManyToOne(targetEntity="FrontBundle\Entity\User") 
   * @ORM\JoinColumn(nullable=false)
   */
   private $user;


    /** 
   * @ORM\ManyToOne(targetEntity="BackBundle\Entity\Service") 
   * @ORM\JoinColumn(nullable=true)
   */
   private $service;

    /** 
   * @ORM\ManyToOne(targetEntity="BackBundle\Entity\Options") 
   * @ORM\JoinColumn(nullable=true)
   */
   private $specialite;
   


     /**
     * Many Users have Many Groups.
     * @ORM\ManyToMany(targetEntity="Membre")
     * @ORM\JoinTable(name="membre_annonce")
     */
   private $membres;


      /**
     * Many Users have Many Groups.
     * @ORM\ManyToMany(targetEntity="Mission")
     * @ORM\JoinTable(name="mission_annonce")
     */
   private $mission;









      /**
     * Many Users have Many Groups.
     * @ORM\ManyToMany(targetEntity="Jour")
     * @ORM\JoinTable(name="jour_annonce")
     */
   private $jours;


     /**
     * Many Users have Many Groups.
     * @ORM\ManyToMany(targetEntity="Dates",cascade={"persist", "remove"})
     * @ORM\JoinTable(name="dates_annonce")
     */
   private $dates;



    /**
     * @var string
     *
     * @ORM\Column(name="devis", type="string", length=255,nullable=true)
     * 
     */
    private $devis;


      /**
     * @var integer
     *
     * @ORM\Column(name="note", type="integer", nullable=true)
     * 
     */
    private $note;


  
public function __construct()
{
    $this->membres = new ArrayCollection();
     $this->jours = new ArrayCollection();
     $this->dates = new ArrayCollection();
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
     * @return Annonce
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
     * @return Annonce
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
     * Set image
     *
     * @param string $image
     *
     * @return Annonce
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return Annonce
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
     * Set ville
     *
     * @param string $ville
     *
     * @return Annonce
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
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Annonce
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
     * Set cp
     *
     * @param integer $cp
     *
     * @return Annonce
     */
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp
     *
     * @return int
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Set datePublication
     *
     * @param \DateTime $datePublication
     *
     * @return Annonce
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
     * Set secteur
     *
     * @param string $secteur
     *
     * @return Annonce
     */
    public function setSecteur($secteur)
    {
        $this->secteur = $secteur;

        return $this;
    }

    /**
     * Get secteur
     *
     * @return string
     */
    public function getSecteur()
    {
        return $this->secteur;
    }

    /**
     * Set publier
     *
     * @param boolean $publier
     *
     * @return Annonce
     */
    public function setPublier($publier)
    {
        $this->publier = $publier;

        return $this;
    }

    /**
     * Get publier
     *
     * @return bool
     */
    public function getPublier()
    {
        return $this->publier;
    }

    /**
     * Set typeAnnance
     *
     * @param string $typeAnnance
     *
     * @return Annonce
     */
    public function setTypeAnnance($typeAnnance)
    {
        $this->typeAnnance = $typeAnnance;

        return $this;
    }

    /**
     * Get typeAnnance
     *
     * @return string
     */
    public function getTypeAnnance()
    {
        return $this->typeAnnance;
    }



    /**
     * Set datePrevu
     *
     * @param \DateTime $datePrevu
     *
     * @return Annonce
     */
    public function setDatePrevu($datePrevu)
    {
        $this->datePrevu = $datePrevu;

        return $this;
    }

    /**
     * Get datePrevu
     *
     * @return \DateTime
     */
    public function getDatePrevu()
    {
        return $this->datePrevu;
    }

    /**
     * Set autres
     *
     * @param string $autres
     *
     * @return Annonce
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
     * Set user
     *
     * @param \FrontBundle\Entity\User $user
     *
     * @return Annonce
     */
    public function setUser(\FrontBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \FrontBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

  

    /**
     * Set portfolio
     *
     * @param string $portfolio
     *
     * @return Annonce
     */
    public function setPortfolio($portfolio)
    {
        $this->portfolio = $portfolio;

        return $this;
    }

    /**
     * Get portfolio
     *
     * @return string
     */
    public function getPortfolio()
    {
        return $this->portfolio;
    }

    /**
     * Set horaire
     *
     * @param string $horaire
     *
     * @return Annonce
     */
    public function setHoraire($horaire)
    {
        $this->horaire = $horaire;

        return $this;
    }

    /**
     * Get horaire
     *
     * @return string
     */
    public function getHoraire()
    {
        return $this->horaire;
    }

    /**
     * Set zone
     *
     * @param string $zone
     *
     * @return Annonce
     */
    public function setZone($zone)
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * Get zone
     *
     * @return string
     */
    public function getZone()
    {
        return $this->zone;
    }

    /**
     * Set option
     *
     * @param string $option
     *
     * @return Annonce
     */
    public function setOption($option)
    {
        $this->option = $option;

        return $this;
    }

    /**
     * Get option
     *
     * @return string
     */
    public function getOption()
    {
        return $this->option;
    }


    /**
     * Set specification
     *
     * @param string $specification
     *
     * @return Annonce
     */
    public function setSpecification($specification)
    {
        $this->specification = $specification;

        return $this;
    }

    /**
     * Get specification
     *
     * @return string
     */
    public function getSpecification()
    {
        return $this->specification;
    }

    /**
     * Set avantages
     *
     * @param string $avantages
     *
     * @return Annonce
     */
    public function setAvantages($avantages)
    {
        $this->avantages = $avantages;

        return $this;
    }

    /**
     * Get avantages
     *
     * @return string
     */
    public function getAvantages()
    {
        return $this->avantages;
    }

 
    /**
     * Set telephone
     *
     * @param integer $telephone
     *
     * @return Annonce
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
     * @return Annonce
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
     * Set facebook
     *
     * @param string $facebook
     *
     * @return Annonce
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set linkedin
     *
     * @param string $linkedin
     *
     * @return Annonce
     */
    public function setLinkedin($linkedin)
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    /**
     * Get linkedin
     *
     * @return string
     */
    public function getLinkedin()
    {
        return $this->linkedin;
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     *
     * @return Annonce
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

   

    /**
     * Set typeHoraire
     *
     * @param string $typeHoraire
     *
     * @return Annonce
     */
    public function setTypeHoraire($typeHoraire)
    {
        $this->typeHoraire = $typeHoraire;

        return $this;
    }

    /**
     * Get typeHoraire
     *
     * @return string
     */
    public function getTypeHoraire()
    {
        return $this->typeHoraire;
    }

    /**
     * Set typeVisite
     *
     * @param string $typeVisite
     *
     * @return Annonce
     */
    public function setTypeVisite($typeVisite)
    {
        $this->typeVisite = $typeVisite;

        return $this;
    }

    /**
     * Get typeVisite
     *
     * @return string
     */
    public function getTypeVisite()
    {
        return $this->typeVisite;
    }

    /**
     * Set nbrIntervention
     *
     * @param integer $nbrIntervention
     *
     * @return Annonce
     */
    public function setNbrIntervention($nbrIntervention)
    {
        $this->nbrIntervention = $nbrIntervention;

        return $this;
    }

    /**
     * Get nbrIntervention
     *
     * @return integer
     */
    public function getNbrIntervention()
    {
        return $this->nbrIntervention;
    }

    /**
     * Set conditions
     *
     * @param string $conditions
     *
     * @return Annonce
     */
    public function setConditions($conditions)
    {
        $this->conditions = $conditions;

        return $this;
    }

    /**
     * Get conditions
     *
     * @return string
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * Add membre
     *
     * @param \BackBundle\Entity\Membre $membre
     *
     * @return Annonce
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
     * Add jour
     *
     * @param \BackBundle\Entity\Membre $jour
     *
     * @return Annonce
     */
    public function addJour(\BackBundle\Entity\Membre $jour)
    {
        $this->jours[] = $jour;

        return $this;
    }

    /**
     * Remove jour
     *
     * @param \BackBundle\Entity\Membre $jour
     */
    public function removeJour(\BackBundle\Entity\Membre $jour)
    {
        $this->jours->removeElement($jour);
    }

    /**
     * Get jours
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getJours()
    {
        return $this->jours;
    }

    /**
     * Set nbrmembres
     *
     * @param integer $nbrmembres
     *
     * @return Annonce
     */
    public function setNbrmembres($nbrmembres)
    {
        $this->nbrmembres = $nbrmembres;

        return $this;
    }

    /**
     * Get nbrmembres
     *
     * @return integer
     */
    public function getNbrmembres()
    {
        return $this->nbrmembres;
    }


    /**
     * Set service
     *
     * @param \BackBundle\Entity\Service $service
     *
     * @return Annonce
     */
    public function setService(\BackBundle\Entity\Service $service = null)
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
     * Set specialite
     *
     * @param \BackBundle\Entity\Options $specialite
     *
     * @return Annonce
     */
    public function setSpecialite(\BackBundle\Entity\Options $specialite = null)
    {
        $this->specialite = $specialite;

        return $this;
    }

    /**
     * Get specialite
     *
     * @return \BackBundle\Entity\Options
     */
    public function getSpecialite()
    {
        return $this->specialite;
    }

    /**
     * Set nbrsemaine
     *
     * @param integer $nbrsemaine
     *
     * @return Annonce
     */
    public function setNbrsemaine($nbrsemaine)
    {
        $this->nbrsemaine = $nbrsemaine;

        return $this;
    }

    /**
     * Get nbrsemaine
     *
     * @return integer
     */
    public function getNbrsemaine()
    {
        return $this->nbrsemaine;
    }

    /**
     * Set telephoneII
     *
     * @param integer $telephoneII
     *
     * @return Annonce
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
     * Set email
     *
     * @param string $email
     *
     * @return Annonce
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
     * Set dateVisite
     *
     * @param \DateTime $dateVisite
     *
     * @return Annonce
     */
    public function setDateVisite($dateVisite)
    {
        $this->dateVisite = $dateVisite;

        return $this;
    }

    /**
     * Get dateVisite
     *
     * @return \DateTime
     */
    public function getDateVisite()
    {
        return $this->dateVisite;
    }

    /**
     * Add date
     *
     * @param \BackBundle\Entity\Dates $date
     *
     * @return Annonce
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
     * Set typetarif
     *
     * @param string $typetarif
     *
     * @return Annonce
     */
    public function setTypetarif($typetarif)
    {
        $this->typetarif = $typetarif;

        return $this;
    }

    /**
     * Get typetarif
     *
     * @return string
     */
    public function getTypetarif()
    {
        return $this->typetarif;
    }

    /**
     * Set cordaffiche
     *
     * @param boolean $cordaffiche
     *
     * @return Annonce
     */
    public function setCordaffiche($cordaffiche)
    {
        $this->cordaffiche = $cordaffiche;

        return $this;
    }

    /**
     * Get cordaffiche
     *
     * @return boolean
     */
    public function getCordaffiche()
    {
        return $this->cordaffiche;
    }

    /**
     * Add mission
     *
     * @param \BackBundle\Entity\Mission $mission
     *
     * @return Annonce
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
     * Set achat
     *
     * @param boolean $achat
     *
     * @return Annonce
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
     * Set aport
     *
     * @param boolean $aport
     *
     * @return Annonce
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
     * Set depart
     *
     * @param string $depart
     *
     * @return Annonce
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
     * @return Annonce
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
     * Set place
     *
     * @param string $place
     *
     * @return Annonce
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set produits
     *
     * @param string $produits
     *
     * @return Annonce
     */
    public function setProduits($produits)
    {
        $this->produits = $produits;

        return $this;
    }

    /**
     * Get produits
     *
     * @return string
     */
    public function getProduits()
    {
        return $this->produits;
    }

    /**
     * Set adressmembre
     *
     * @param boolean $adressmembre
     *
     * @return Annonce
     */
    public function setAdressmembre($adressmembre)
    {
        $this->adressmembre = $adressmembre;

        return $this;
    }

    /**
     * Get adressmembre
     *
     * @return boolean
     */
    public function getAdressmembre()
    {
        return $this->adressmembre;
    }

    /**
     * Set trajet
     *
     * @param boolean $trajet
     *
     * @return Annonce
     */
    public function setTrajet($trajet)
    {
        $this->trajet = $trajet;

        return $this;
    }

    /**
     * Get trajet
     *
     * @return boolean
     */
    public function getTrajet()
    {
        return $this->trajet;
    }

    /**
     * Set devis
     *
     * @param string $devis
     *
     * @return Annonce
     */
    public function setDevis($devis)
    {
        $this->devis = $devis;

        return $this;
    }

    /**
     * Get devis
     *
     * @return string
     */
    public function getDevis()
    {
        return $this->devis;
    }

    /**
     * Set note
     *
     * @param integer $note
     *
     * @return Annonce
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return integer
     */
    public function getNote()
    {
        return $this->note;
    }
}
