<?php

namespace App\Entity;

use App\Repository\VisiteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=VisiteRepository::class)
 */
class Visite
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $poids;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $taille;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $pression;

    /**
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank(message="vous devez inscrire un motif de visite")
     */
    private $motifVisite;

    /**
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank(message="vous devez indiquer un traitement")
     */
    private $traitement;

    /**
     * @ORM\Column(type="date")
     */
    private $dateCrea;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, cascade={"remove"}, inversedBy="visites")
     * @ORM\JoinColumn(nullable=false)
     */
    private $patient;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMotifVisite(): ?string
    {
        return $this->motifVisite;
    }

    public function setMotifVisite(string $motifVisite): self
    {
        $this->motifVisite = $motifVisite;

        return $this;
    }

    public function getTraitement(): ?string
    {
        return $this->traitement;
    }

    public function setTraitement(string $traitement): self
    {
        $this->traitement = $traitement;

        return $this;
    }

    public function getDateCrea(): ?\DateTimeInterface
    {
        return $this->dateCrea;
    }

    public function setDateCrea(\DateTimeInterface $dateCrea): self
    {
        $this->dateCrea = $dateCrea;

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

    /**
     * @return mixed
     */
    public function getPoids()
    {
        return $this->poids;
    }

    /**
     * @param mixed $poids
     */
    public function setPoids($poids): void
    {
        $this->poids = $poids;
    }

    /**
     * @return mixed
     */
    public function getTaille()
    {
        return $this->taille;
    }

    /**
     * @param mixed $taille
     */
    public function setTaille($taille): void
    {
        $this->taille = $taille;
    }

    /**
     * @return mixed
     */
    public function getPression()
    {
        return $this->pression;
    }

    /**
     * @param mixed $pression
     */
    public function setPression($pression): void
    {
        $this->pression = $pression;
    }
}
