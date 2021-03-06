<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
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
     * @ORM\Column(type="text", length=3600, nullable=true)
     */
    private $description;

    /**
     * @var User|null
     * @ORM\ManyToOne(targetEntity="User", inversedBy="reportedTasks")
     * @ORM\JoinColumn(name="reporter_id", referencedColumnName="id")
     */
    private $reporter;

    /**
     * @var User|null
     * @ORM\ManyToOne(targetEntity="User", inversedBy="assignedTasks")
     * @ORM\JoinColumn(name="assigned_user_id", referencedColumnName="id", nullable=true)
     */
    private $assignee;

    /**
     * @var Board|null
     * @ORM\ManyToOne(targetEntity="Board", inversedBy="assignedTasks")
     * @ORM\JoinColumn(name="board_id", referencedColumnName="id")
     */
    private $board;

    /**
     * @var Column|null
     * @ORM\ManyToOne(targetEntity="Column", inversedBy="tasks")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $estimate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LoggedTime", mappedBy="task", orphanRemoval=true)
     */
    private $loggedTime;

    public function __construct()
    {
        $this->loggedTime = new ArrayCollection();
    }
    public function __toString()
    {
        return $this->title;
    }

    public function asArray()
    {
        $data = [];
        foreach ($this as $k => $v) {
            $data[$k] = $v;
        }

        return $data;
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getReporter(): ?User
    {
        return $this->reporter;
    }

    public function setReporter(User $reporter): self
    {
        $this->reporter = $reporter;

        return $this;
    }

    public function getAssignee(): ?User
    {
        return $this->assignee;
    }

    public function setAssignee(User $user): self
    {
        $this->assignee = $user;

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
     * @param Board $board
     * @return $this
     */
    public function setBoard(Board $board): self
    {
        $this->board = $board;

        return $this;
    }

    /**
     * @return Column|null
     */
    public function getStatus(): ?Column
    {
        return $this->status;
    }

    /**
     * @param Column $status
     * @return $this
     */
    public function setStatus(Column $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getEstimate(): ?int
    {
        return $this->estimate;
    }

    public function setEstimate(?int $estimate): self
    {
        $this->estimate = $estimate;

        return $this;
    }

    /**
     * @return Collection|LoggedTime[]
     */
    public function getLoggedTime(): Collection
    {
        return $this->loggedTime;
    }

    public function addLoggedTime(LoggedTime $loggedTime): self
    {
        if (!$this->loggedTime->contains($loggedTime)) {
            $this->loggedTime[] = $loggedTime;
            $loggedTime->setTask($this);
        }

        return $this;
    }

    public function removeLoggedTime(LoggedTime $loggedTime): self
    {
        if ($this->loggedTime->contains($loggedTime)) {
            $this->loggedTime->removeElement($loggedTime);
            // set the owning side to null (unless already changed)
            if ($loggedTime->getTask() === $this) {
                $loggedTime->setTask(null);
            }
        }

        return $this;
    }
}
