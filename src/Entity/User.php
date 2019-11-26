<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\ArrayType;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=180, unique=false, nullable=true)
     */
    private $name;

    /**
     * @var Collection|Board[]
     * @ORM\ManyToMany(targetEntity="App\Entity\Board", mappedBy="members")
     * @ORM\JoinTable(name="boards_members",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="board_id", referencedColumnName="id", unique=true)})
     */
    private $boards;

    /**
     * @var Collection|Board[]
     * @ORM\OneToMany(targetEntity="App\Entity\Board", mappedBy="author")
     */
    private $ownBoards;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    private $availableBoards;

    public function __construct()
    {
        $this->boards = new ArrayCollection();
        $this->ownBoards = new ArrayCollection();
    }

    public function __toString()
    {
        return (string)$this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    public function getName(): string
    {
        return (string) $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Board[]|Collection
     */
    public function getBoards(): Collection
    {
        return $this->boards;
    }

    /**
     * @param Board[]|Collection $boards
     */
    public function setBoards(Collection $boards)
    {
        $this->boards = $boards;

        return $this;
    }

    /**
     * @return Board[]|Collection
     */
    public function getOwnBoards(): ?Collection
    {
        return $this->ownBoards;
    }

    /**
     * @param $ownBoards
     * @return $this
     */
    public function setOwnBoards(Collection $ownBoards): self
    {
        $this->ownBoards = $ownBoards;

        return $this;
    }

    /**
     * Gets all boards which are available for this user
     * included own boards and boards where this user marked as a member
     * @return Collection|null
     */
    public function getAvailableBoards(): ?Collection
    {
        return new ArrayCollection(array_merge($this->ownBoards->toArray(), $this->boards->toArray()));
    }

    /**
     * Checks if the user have permissions to view this board
     * @param Board $board
     * @return bool
     */
    public function isBoardAvailable(Board $board)
    {
        return in_array($board,$this->getAvailableBoards()->toArray());
    }

    /**
     * Checks if the user is the author of the board
     * @param Board $board
     * @return bool
     */
    public function isAuthor(Board $board)
    {
        return in_array($board, $this->ownBoards->toArray());
    }
}
