<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\Column(type="integer")
     */
    private $Owner;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creatingDate;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="members")
     */
    private $members = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $tasks = [];

    public function __construct()
    {
        $this->members = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?int
    {
        return $this->Owner;
    }

    public function setOwner(int $Owner): self
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

    public function getMembers(): ?array
    {
        return $this->members;
    }

    public function setMembers(array $members): self
    {
        $this->members = $members;

        return $this;
    }

    public function getTasks(): ?array
    {
        return $this->tasks;
    }

    public function setTasks(?array $tasks): self
    {
        $this->tasks = $tasks;

        return $this;
    }
}
