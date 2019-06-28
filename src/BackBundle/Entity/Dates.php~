<?php

namespace BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jour
 *
 * @ORM\Table(name="dates")
 * @ORM\Entity(repositoryClass="BackBundle\Repository\DatesRepository")
 */
class Dates
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
     * @var date
     *
     * @ORM\Column(name="datev", type="datetime")
     */
    private $datev;


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
     * Set dev
     *
     * @param date $datev
     *
     * @return datev
     */
    public function setDatev($datev)
    {
        $this->datev = $datev;

        return $this;
    }

    /**
     * Get datev
     *
     * @return date
     */
    public function getDatev()
    {
        return $this->datev;
    }
}
