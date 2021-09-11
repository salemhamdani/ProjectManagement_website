<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $budget;

    /**
     * @ORM\OneToMany(targetEntity=Activity::class, mappedBy="project", orphanRemoval=true)
     */
    private $activities;

    /**
     * @ORM\OneToMany(targetEntity=BudgetLine::class, mappedBy="project", orphanRemoval=true)
     */
    private $budgetlines;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="projects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    public function __construct()
    {
        $this->activities = new ArrayCollection();
        $this->budgetlines = new ArrayCollection();
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

    public function getBudget(): ?float
    {
        return $this->budget;
    }

    public function setBudget(float $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    /**
     * @return Collection|Activity[]
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function addActivity(Activity $activity): self
    {
        if (!$this->activities->contains($activity)) {
            $this->activities[] = $activity;
            $activity->setProject($this);
        }

        return $this;
    }

    public function removeActivity(Activity $activity): self
    {
        if ($this->activities->removeElement($activity)) {
            // set the owning side to null (unless already changed)
            if ($activity->getProject() === $this) {
                $activity->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BudgetLine[]
     */
    public function getBudgetlines(): Collection
    {
        return $this->budgetlines;
    }

    public function addBudgetline(BudgetLine $budgetline): self
    {
        if (!$this->budgetlines->contains($budgetline)) {
            $this->budgetlines[] = $budgetline;
            $budgetline->setProject($this);
        }

        return $this;
    }

    public function removeBudgetline(BudgetLine $budgetline): self
    {
        if ($this->budgetlines->removeElement($budgetline)) {
            // set the owning side to null (unless already changed)
            if ($budgetline->getProject() === $this) {
                $budgetline->setProject(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->name;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
