<?php

namespace App\Entity;

use App\Repository\EquipmentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EquipmentRepository::class)
 */
class Equipment
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
    private $serialNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $keywords;

    /**
     * @ORM\Column(type="datetime")
     */
    private $manipulatedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $deleted;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="equipment")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Mark::class, inversedBy="equipment")
     */
    private $mark;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="equipment")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Specificity::class, inversedBy="equipment")
     */
    private $specificity;

    /**
     * @ORM\ManyToOne(targetEntity=Location::class, inversedBy="equipment")
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity=Status::class, inversedBy="equipment")
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSerialNumber(): ?string
    {
        return $this->serialNumber;
    }

    public function setSerialNumber(string $serialNumber): self
    {
        $this->serialNumber = $serialNumber;

        return $this;
    }

    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    public function setKeywords(string $keywords): self
    {
        $this->keywords = $keywords;

        return $this;
    }

    public function getManipulatedAt(): ?\DateTimeInterface
    {
        return $this->manipulatedAt;
    }

    public function setManipulatedAt(\DateTimeInterface $manipulatedAt): self
    {
        $this->manipulatedAt = $manipulatedAt;

        return $this;
    }

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getMark(): ?Mark
    {
        return $this->mark;
    }

    public function setMark(?Mark $mark): self
    {
        $this->mark = $mark;

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

    public function getSpecificity(): ?Specificity
    {
        return $this->specificity;
    }

    public function setSpecificity(?Specificity $specificity): self
    {
        $this->specificity = $specificity;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }
}
