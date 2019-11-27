<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BoardRepository")
 */
class Board
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $name;

    /**
     * @var User|null
     * @ORM\ManyToOne(targetEntity="User", inversedBy="ownBoards")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    private $author;

    /**
     * @var Collection|User[]
     * @ORM\ManyToMany(targetEntity="User", inversedBy="boards")
     * @ORM\JoinTable(name="boards_members",
     *     joinColumns={@ORM\JoinColumn(name="board_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", unique=true)})
     */
    private $members;

    /**
     * @var Collection|Task[]
     * @ORM\OneToMany(targetEntity="Task", mappedBy="board")
     */
    private $tasks;

    /**
     * @var Collection|Column[]
     * @ORM\OneToMany(targetEntity="Column", mappedBy="board")
     */
    private $columns;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    public function __construct()
    {
        $this->members = new ArrayCollection();
        $this->tasks = new ArrayCollection();
        $this->columns = new ArrayCollection();
    }

    public function __toString(): string
    {
        return "($this->id).$this->name";
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * @param User|null $author
     * @return $this
     */
    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return User[]|Collection
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    /**
     * @param $members
     * @return $this
     */
    public function setMembers(Collection $members): self
    {
        $this->members = $members;

        return $this;
    }

    /**
     * Add new member to board
     * @param User $user
     * @return $this
     */
    public function addMember(User $user): self
    {
        $this->members->add($user);

        return $this;
    }

    /**
     * Remove member from board
     * @param User $user
     * @return $this
     */
    public function removeMember(User $user): self
    {
        if ($this->members->contains($user)) {
            $this->members->removeElement($user);
        }

        return $this;
    }

    /**
     * @return Task[]|Collection
     */
    public function getTasks(): ?Collection
    {
        return $this->tasks;
    }

    /**
     * @param Collection $tasks
     * @return $this
     */
    public function setTasks(Collection $tasks): self
    {
        $this->tasks = $tasks;

        return $this;
    }

    /**
     * @return Column[]|Collection
     */
    public function getColumns(): Collection
    {
        return $this->columns;
    }

    /**
     * @param Collection $columns
     * @return $this
     */
    public function setColumns(Collection $columns): self
    {
        $this->columns = $columns;

        return $this;
    }
}