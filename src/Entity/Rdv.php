<?php

namespace App\Entity;

use App\Repository\RdvRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RdvRepository::class)
 */
class Rdv
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $motif;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="rdvs", cascade={"remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $patient;

    /**
     * @ORM\Column(type="date")
     */
    private $dateRdv;

    /**
     * @ORM\Column(type="time")
     */
    private $heureRdv;


    public function getHeureRdv()
    {
        return $this->heureRdv;
    }


    public function setHeureRdv( $heureRdv): self
    {
        $this->heureRdv = $heureRdv;

        return $this;
    }


    public function getDateRdv()
    {
        return $this->dateRdv;
    }

    public function setDateRdv( $dateRdv): self
    {
        $this->dateRdv = $dateRdv;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(?string $motif): self
    {
        $this->motif = $motif;

        return $this;
    }


    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }
}
