<?php

namespace App\Entity;

use App\Repository\BeerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BeerRepository::class)
 */
class Beer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $alcohol;

    /**
     * @ORM\ManyToOne(targetEntity=brewerie::class, inversedBy="beers")
     */
    private $brewerie;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="beers")
     */
    private $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAlcohol(): ?string
    {
        return $this->alcohol;
    }

    public function setAlcohol(string $alcohol): self
    {
        $this->alcohol = $alcohol;

        return $this;
    }

    public function getBrewerie(): ?brewerie
    {
        return $this->brewerie;
    }

    public function setBrewerie(?brewerie $brewerie): self
    {
        $this->brewerie = $brewerie;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }
}
