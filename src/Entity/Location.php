<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LocationRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=LocationRepository::class)
 * @UniqueEntity
 * (
 * fields={"wording"},
 * message="Ce site existe déjà dans votre liste de site connu par l'application"
 * )
 */
class Location
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 5,
     *      max = 255,
     *      minMessage = "Votre libellé doit contenir au moins {{ limit }} caractères.",
     *      maxMessage = "Votre libellé doit contenir au plus {{ limit }} caractères.",
     *      allowEmptyString = false)
     */
    private $wording;

    /**
     * @ORM\OneToMany(targetEntity=Equipment::class, mappedBy="location")
     */
    private $equipment;

    public function __construct()
    {
        $this->equipment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWording(): ?string
    {
        return $this->wording;
    }

    public function setWording(string $wording): self
    {
        $this->wording = $wording;

        return $this;
    }

    /**
     * @return Collection|Equipment[]
     */
    public function getEquipment(): Collection
    {
        return $this->equipment;
    }

    public function addEquipment(Equipment $equipment): self
    {
        if (!$this->equipment->contains($equipment)) {
            $this->equipment[] = $equipment;
            $equipment->setLocation($this);
        }

        return $this;
    }

    public function removeEquipment(Equipment $equipment): self
    {
        if ($this->equipment->contains($equipment)) {
            $this->equipment->removeElement($equipment);
            // set the owning side to null (unless already changed)
            if ($equipment->getLocation() === $this) {
                $equipment->setLocation(null);
            }
        }

        return $this;
    }
}
