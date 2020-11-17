<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 *  @UniqueEntity(
 * fields={"email"},
 * message="Un autre utilisateur s'est déjà inscrit avec cette adresse mail, merci de la modifier !"
 * )
 * 
 *  @UniqueEntity(
 * fields={"username"},
 * message="Un autre utilisateur s'est déjà inscrit avec ce pseudo, merci de le modifier !"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\Regex(
     *     pattern="/[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/",
     *     message="Ne doit pas contenir de chiffre ou de charactères spéciaux"
     * )
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Le nom doit contenir au moins {{ limit }} caractères.",
     *      maxMessage = "Le nom doit contenir au plus {{ limit }} caractères.",
     *      allowEmptyString = false)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(
     *     pattern="/[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/",
     *     message="Ne doit pas contenir de chiffre ou de charactères spéciaux"
     * )
     * 
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Le prénom doit contenir au moins {{ limit }} caractères.",
     *      maxMessage = "Le prénom doit contenir au plus {{ limit }} caractères.",
     *      allowEmptyString = false)
     */
    private $lastName;

    /**
     * @var string|null
     * @Assert\Regex(
     *     pattern="/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/",
     *     message="Doit contenir un chiffre, une lettre, un charactères spéciaux et doit avoir faire une taille de 8"
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(
     *     message = "'{{ value }}' n'est pas un email correct."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $present;

    /**
     * @ORM\OneToMany(targetEntity=Equipment::class, mappedBy="user")
     */
    private $equipment;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    private $plainPassword;

    /**
     * @ORM\OneToMany(targetEntity=Intervention::class, mappedBy="user")
     */
    private $interventions;

    /**
     * @ORM\ManyToMany(targetEntity=Role::class, mappedBy="users")
     */
    private $userRoles;

    public function __construct()
    {
        $this->equipment = new ArrayCollection();
        $this->interventions = new ArrayCollection();
        $this->userRoles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPresent(): ?bool
    {
        return $this->present;
    }

    public function setPresent(bool $present): self
    {
        $this->present = $present;

        return $this;
    }

    /**
     * Affiche le nom complet
     *
     * @return void
     */
    public function getFullName()
    {
        return "{$this->firstName} " . strtoupper("{$this->lastName}");
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    public function getSalt()
    {
    }

    public function eraseCredentials()
    {
    }

    public function getRoles()
    {
        // Récupère le array_collections des roles de l'utilistaeur
        $roles = $this->userRoles->toArray();

        // Transform le array_collection en un array simple
        $roles = $this->userRoles->map(function($role){
            return $role->getTitle();
        })->toArray();

        // Si l'utilisateur à le role public on lui enlève le role user
        if(!(in_array("ROLE_PUBLIC", $roles))){
            
            $roles[] = "ROLE_USER";
        }

        // ON enlève les doublons
        $roles = array_unique($roles);

        return $roles;
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
            $equipment->setUser($this);
        }

        return $this;
    }

    public function removeEquipment(Equipment $equipment): self
    {
        if ($this->equipment->contains($equipment)) {
            $this->equipment->removeElement($equipment);
            // set the owning side to null (unless already changed)
            if ($equipment->getUser() === $this) {
                $equipment->setUser(null);
            }
        }

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return Collection|Intervention[]
     */
    public function getInterventions(): Collection
    {
        return $this->interventions;
    }

    public function addIntervention(Intervention $intervention): self
    {
        if (!$this->interventions->contains($intervention)) {
            $this->interventions[] = $intervention;
            $intervention->setUser($this);
        }

        return $this;
    }

    public function removeIntervention(Intervention $intervention): self
    {
        if ($this->interventions->contains($intervention)) {
            $this->interventions->removeElement($intervention);
            // set the owning side to null (unless already changed)
            if ($intervention->getUser() === $this) {
                $intervention->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Role[]
     */
    public function getUserRoles(): Collection
    {
        return $this->userRoles;
    }

    public function addUserRole(Role $userRole): self
    {
        if (!$this->userRoles->contains($userRole)) {
            $this->userRoles[] = $userRole;
            $userRole->addUser($this);
        }

        return $this;
    }

    public function removeUserRole(Role $userRole): self
    {
        if ($this->userRoles->contains($userRole)) {
            $this->userRoles->removeElement($userRole);
            $userRole->removeUser($this);
        }

        return $this;
    }
}
