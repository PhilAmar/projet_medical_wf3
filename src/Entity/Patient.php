<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PatientRepository::class)
 */
class Patient
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="la civilité est obligatoire")
     */
    private $civilite;

    /**
     * @ORM\Column(type="float", nullable=true)
     *
     */
    private $poids;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     */
    private $taille;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $pression;

    /**
     * @ORM\Column(type="string", length=40)
     * @Assert\NotBlank(message="le nom est obligatoire")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=40)
     * @Assert\NotBlank(message="le prénom est obligatoire")
     */
    private $prenom;

    /**
     * @ORM\Column(type="date")
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\Email(message="email invalide")
     */
    private $email;


    /**
     * @ORM\Column(type="string", length=10)
     *
     * @Assert\NotBlank(message="veuillez renseigner un numéro de téléphone")
     *
     * @Assert\Length(min="10", minMessage="votre numéro de téléphone doit faire {{ limit }} chiffres")
     *
     * @Assert\Length(max="10", maxMessage="votre numéro de téléphone doit faire {{ limit }} chiffres")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=15)
     *
     * @Assert\NotBlank(message="veuillez renseigner votre numéro de sécurité sociale")
     *
     * @Assert\Length(min="13", minMessage="votre numéro de sécurité sociale doit faire {{ limit }} chiffres")
     *
     * @Assert\Length(max="15", maxMessage="votre numéro de sécurité sociale doit faire {{ limit }} chiffres")
     */
    private $secu;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $antecedents;

    /**
     * @ORM\Column(type="date")
     */
    private $dateCrea;

    /**
     * @ORM\OneToMany(targetEntity=Rdv::class, mappedBy="patient", cascade={"remove"})
     */
    private $rdvs;

    /**
     * @ORM\OneToMany(targetEntity=Visite::class, mappedBy="patient")
     */
    private $visites;

    public function __construct()
    {
        $this->rdvs = new ArrayCollection();
        $this->visites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getSecu(): ?string
    {
        return $this->secu;
    }

    public function setSecu(string $secu): self
    {
        $this->secu = $secu;

        return $this;
    }

    public function getAntecedents(): ?string
    {
        return $this->antecedents;
    }

    public function setAntecedents(?string $antecedents): self
    {
        $this->antecedents = $antecedents;

        return $this;
    }

    public function getDatecrea(): ?DateTimeInterface
    {
        return $this->dateCrea;
    }

    public function setDatecrea(DateTimeInterface $dateCrea): self
    {
        $this->dateCrea = $dateCrea;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

    /**
     * @param mixed $civilite
     */
    public function setCivilite($civilite): void
    {
        $this->civilite = $civilite;
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


    /**
     * @return Collection|Rdv[]
     */
    public function getRdvs(): Collection
    {
        return $this->rdvs;
    }

    public function addRdv(Rdv $rdv): self
    {
        if (!$this->rdvs->contains($rdv)) {
            $this->rdvs[] = $rdv;
            $rdv->setPatient($this);
        }

        return $this;
    }

    public function removeRdv(Rdv $rdv): self
    {
        if ($this->rdvs->contains($rdv)) {
            $this->rdvs->removeElement($rdv);
            if ($rdv->getPatient() === $this) {
                $rdv->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Visite[]
     */
    public function getVisites(): Collection
    {
        return $this->visites;
    }

    public function addVisite(Visite $visite): self
    {
        if (!$this->visites->contains($visite)) {
            $this->visites[] = $visite;
            $visite->setPatient($this);
        }

        return $this;
    }

    public function removeVisite(Visite $visite): self
    {
        if ($this->visites->contains($visite)) {
            $this->visites->removeElement($visite);
            if ($visite->getPatient() === $this) {
                $visite->setPatient(null);
            }
        }

        return $this;
    }
}
