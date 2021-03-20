<?php

namespace App\Entity;

use App\Repository\UtilisateursRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UtilisateursRepository::class)
 */
class Utilisateurs implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nomUtilisateur;

    /**
     * @ORM\Column(type="string", length=50)
     *
     * @Assert\NotBlank(message="Veuillez indiquer votre prénom et nom")
     */
    private $nomComplet;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $fonction;

    /**
     * @ORM\Column(type="string", length=10)
     *
     * @Assert\NotBlank(message="veuillez renseigner un numéro de téléphone")
     *
     * @Assert\Length(min="10", minMessage="votre numéro de téléphone doit faire {{ limit }} chiffres")
     *
     * @Assert\Length(max="10", maxMessage="votre numéro de téléphone doit faire {{ limit }} chiffres")
     *
     * @Assert\Regex("/^[0-9]/", message="Chiffres uniquement")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @var string|null
     *
     * @Assert\NotBlank(message="Le mot de passe est obligatoire")
     * @Assert\Regex("/^[a-zA-Z0-9]{6,20}$/", message="Mot de passe non conforme")
     *
     */
    private $plainMdp;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomUtilisateur(): ?string
    {
        return $this->nomUtilisateur;
    }

    public function setNomUtilisateur(string $nomUtilisateur): self
    {
        $this->nomUtilisateur = $nomUtilisateur;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $role = 'ROLE_USER';

    /**
     * @return string|null
     */
    public function getPlainMdp(): ?string
    {
        return $this->plainMdp;
    }

    /**
     * @param string|null $plainMdp
     * @return Utilisateurs
     */
    public function setPlainMdp(?string $plainMdp): Utilisateurs
    {
        $this->plainMdp = $plainMdp;

        return $this;

    }


    public function getNomComplet(): ?string
    {
        return $this->nomComplet;
    }


    public function setNomComplet(string $nomComplet): self
    {
        $this->nomComplet = $nomComplet;

        return $this;
    }


    public function getFonction(): ?string
    {
        return $this->fonction;
    }


    public function setFonction(string $fonction): self
    {
        $this->fonction = $fonction;

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

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return [$this->role];
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {

    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {

        return $this->nomUtilisateur;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {

    }
}
