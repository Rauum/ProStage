<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EntrepriseRepository::class)
 */
class Entreprise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 4,
     *      max = 255,
     *      minMessage = "Le nom doit faire au minimum {{ limit }} caractères",
     *      maxMessage = "Le nom doit faire au maximum {{ limit }} caractères"
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
<<<<<<< HEAD
     * @Assert\Regex("# [1-9]* #"), message = "Le numéro de rue n'est pas correct"
     * @Assert\Regex("# allée|rue|avenue|impasse #")
      * @Assert\Regex("# [0-9]{5} #")
=======
     * @Assert\Regex("[1-9]* #"), message = "Le numéro de rue semble incorect"
     * @Assert\Regex("# allée|rue|avenue|impasse #"), message = "Le type de reoute/voie est incorrect"
     * @Assert\Regex("# .* #")
      * @Assert\Regex("# [0-9]{5} #"), message = "Il semble y avoir un problème avec le code postal"
      * @Assert\Regex("# [a-zA-Z]{1,} #")
>>>>>>> 1406028160b0b92ec9c071be28eddbf38d6fd05a
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     */
    private $dommaineActivite;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Assert\NotBlank
     */
    private $numTel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     * @Assert\Url
     */
    private $sitWeb;

    /**
     * @ORM\OneToMany(targetEntity=Stage::class, mappedBy="entreprise")
     */
    private $stages;

    public function __construct()
    {
        $this->stages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getDommaineActivite(): ?string
    {
        return $this->dommaineActivite;
    }

    public function setDommaineActivite(?string $dommaineActivite): self
    {
        $this->dommaineActivite = $dommaineActivite;

        return $this;
    }

    public function getNumTel(): ?string
    {
        return $this->numTel;
    }

    public function setNumTel(?string $numTel): self
    {
        $this->numTel = $numTel;

        return $this;
    }

    public function getSitWeb(): ?string
    {
        return $this->sitWeb;
    }

    public function setSitWeb(?string $sitWeb): self
    {
        $this->sitWeb = $sitWeb;

        return $this;
    }

    /**
     * @return Collection|Stage[]
     */
    public function getStages(): Collection
    {
        return $this->stages;
    }

    public function addStage(Stage $stage): self
    {
        if (!$this->stages->contains($stage)) {
            $this->stages[] = $stage;
            $stage->setEntreprise($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->stages->removeElement($stage)) {
            // set the owning side to null (unless already changed)
            if ($stage->getEntreprise() === $this) {
                $stage->setEntreprise(null);
            }
        }

        return $this;
    }
}
