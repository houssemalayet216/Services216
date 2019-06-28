<?php

namespace BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="BackBundle\Repository\MessageRepository")
 */
class Message
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
     * @ORM\Column(name="nom", type="string", length=255)
     *@Assert\NotBlank(message = "Ce champ est obligatoire.")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     *@Assert\NotBlank(message = "Ce champ est obligatoire.")
     */
    private $prenom;

    /**
     * @var string
     * @ORM\Column(name="adresse", type="string", length=255)
     *@Assert\NotBlank(message = "Ce champ est obligatoire.") 
     * @Assert\Email(
     * message = "The email '{{ value }}' is not a valid email.",
     * checkMX = true)
     * 
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="sujet", type="string", length=255)
     *@Assert\NotBlank(message = "Ce champ est obligatoire.")
     */
    private $sujet;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=255)
     *@Assert\NotBlank(message = "Ce champ est obligatoire.")
     */
    private $message;


        /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     *
     */
    private $status;



    /**
     * @var datetime
     *
     * @ORM\Column(name="datedenvoi", type="datetime")
     *
     */
    private $datedenvoi;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Message
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Message
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Message
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
     * Set sujet
     *
     * @param string $sujet
     *
     * @return Message
     */
    public function setSujet($sujet)
    {
        $this->sujet = $sujet;

        return $this;
    }

    /**
     * Get sujet
     *
     * @return string
     */
    public function getSujet()
    {
        return $this->sujet;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Message
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set datedenvoi
     *
     * @param \DateTime $datedenvoi
     *
     * @return Message
     */
    public function setDatedenvoi($datedenvoi)
    {
        $this->datedenvoi = $datedenvoi;

        return $this;
    }

    /**
     * Get datedenvoi
     *
     * @return \DateTime
     */
    public function getDatedenvoi()
    {
        return $this->datedenvoi;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Message
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}
