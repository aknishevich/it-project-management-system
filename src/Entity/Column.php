<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ColumnRepository")
 */
class Column
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
    private $title;

    /**
     * @var Board|null
     * @ORM\ManyToOne(targetEntity="Board", inversedBy="columns")
     * @ORM\JoinColumn(name="board_id", referencedColumnName="id")
     */
    private $board;

    /**
     * @var Collection|Task[]
     * @ORM\OneToMany(targetEntity="Task", mappedBy="status")
     */
    private $tasks;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Board|null
     */
    public function getBoard(): ?Board
    {
        return $this->board;
    }

    /**
     * @param Board|null $board
     * @return $this
     */
    public function setBoard(?Board $board): self
    {
        $this->board = $board;

        return $this;
    }

    /**
     * @return Task[]|Collection
     */
    public function getTasks(): Collection
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
}
