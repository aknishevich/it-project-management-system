<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 */
class Project
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Owner;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creatingDate;

    /**
     * @var Collection|User[]
     *
     * @ORM\ManyToMany(targetEntity="User", inversedBy="projects")
     * @ORM\JoinTable(name="project_users",
     *     joinColumns={@ORM\JoinColumn(name="project_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", unique=true)}
     *     )
     */
    private $members;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $tasks = [];

    public function __construct()
    {
        $this->members = new ArrayCollection();
        $this->tasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?int
    {
        return $this->Owner;
    }

    public function setOwner($Owner): self
    {
        $this->Owner = $Owner;

        return $this;
    }

    public function getCreatingDate(): ?\DateTimeInterface
    {
        return $this->creatingDate;
    }

    public function setCreatingDate(\DateTimeInterface $creatingDate): self
    {
        $this->creatingDate = $creatingDate;

        return $this;
    }

    public function getMembers(): ?ArrayCollection
    {
        return $this->members;
    }

    public function setMembers(ArrayCollection $members): self
    {
        $this->members = $members;

        return $this;
    }

    public function getTasks(): ?iterable
    {
        return $this->tasks;
    }

    public function setTasks(?array $tasks): self
    {
        $this->tasks = $tasks;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
