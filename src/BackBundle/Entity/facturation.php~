<?php

namespace BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * facturation
 *
 * @ORM\Table(name="facturation")
 * @ORM\Entity(repositoryClass="BackBundle\Repository\facturationRepository")
 */
class facturation
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
     * @var float
     *
     * @ORM\Column(name="montant", type="float")
     */
    private $montant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datepayment", type="datetime")
     */
    private $datepayment;


      /**
     * @var \String
     *
     * @ORM\Column(name="tarification", type="string" ,length=255)
     */
    private $tarification;


    
     /** 
   * @ORM\ManyToOne(targetEntity="BackBundle\Entity\Annonce") 
   * @ORM\JoinColumn(nullable=true)
   */
   private $annonce;


   /** 
   * @ORM\ManyToOne(targetEntity="BackBundle\Entity\Contacter") 
   * @ORM\JoinColumn(nullable=true)
   */
   private $contacter;





    /** 
   * @ORM\ManyToOne(targetEntity="FrontBundle\Entity\User") 
   * @ORM\JoinColumn(nullable=true)
   */
   private $client;



     /** 
   * @ORM\ManyToOne(targetEntity="FrontBundle\Entity\User") 
   * @ORM\JoinColumn(nullable=true)
   */
   private $Agent;












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
     * Set montant
     *
     * @param float $montant
     *
     * @return facturation
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return float
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set datepayment
     *
     * @param \DateTime $datepayment
     *
     * @return facturation
     */
    public function setDatepayment($datepayment)
    {
        $this->datepayment = $datepayment;

        return $this;
    }

    /**
     * Get datepayment
     *
     * @return \DateTime
     */
    public function getDatepayment()
    {
        return $this->datepayment;
    }

    /**
     * Set annonce
     *
     * @param \BackBundle\Entity\Annonce $annonce
     *
     * @return facturation
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
     * Set client
     *
     * @param \FrontBundle\Entity\User $client
     *
     * @return facturation
     */
    public function setClient(\FrontBundle\Entity\User $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \FrontBundle\Entity\User
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set agent
     *
     * @param \FrontBundle\Entity\User $agent
     *
     * @return facturation
     */
    public function setAgent(\FrontBundle\Entity\User $agent = null)
    {
        $this->Agent = $agent;

        return $this;
    }

    /**
     * Get agent
     *
     * @return \FrontBundle\Entity\User
     */
    public function getAgent()
    {
        return $this->Agent;
    }

    /**
     * Set tarification
     *
     * @param string $tarification
     *
     * @return facturation
     */
    public function setTarification($tarification)
    {
        $this->tarification = $tarification;

        return $this;
    }

    /**
     * Get tarification
     *
     * @return string
     */
    public function getTarification()
    {
        return $this->tarification;
    }

    /**
     * Set contacter
     *
     * @param \BackBundle\Entity\Contacter $contacter
     *
     * @return facturation
     */
    public function setContacter(\BackBundle\Entity\Contacter $contacter = null)
    {
        $this->contacter = $contacter;

        return $this;
    }

    /**
     * Get contacter
     *
     * @return \BackBundle\Entity\Contacter
     */
    public function getContacter()
    {
        return $this->contacter;
    }
}
