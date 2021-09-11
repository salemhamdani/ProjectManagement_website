<?php

namespace App\Entity;

use App\Repository\OperationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OperationRepository::class)
 */
class Operation
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
    private $date;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Activity::class, inversedBy="operations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activity;

    /**
     * @ORM\ManyToOne(targetEntity=BudgetLine::class, inversedBy="operations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $budgetLine;

    /**
     * @ORM\OneToMany(targetEntity=PaymentTranche::class, mappedBy="operation", orphanRemoval=true)
     */
    private $paymentTranche;

    /**
     * @ORM\OneToMany(targetEntity=PaymentTrace::class, mappedBy="operation", orphanRemoval=true)
     */
    private $paymentTrace;

    public function __construct()
    {
        $this->paymentTranche = new ArrayCollection();
        $this->paymentTrace = new ArrayCollection();
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

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(?string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

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

    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    public function setActivity(?Activity $activity): self
    {
        $this->activity = $activity;

        return $this;
    }

    public function getBudgetLine(): ?BudgetLine
    {
        return $this->budgetLine;
    }

    public function setBudgetLine(?BudgetLine $budgetLine): self
    {
        $this->budgetLine = $budgetLine;

        return $this;
    }

    /**
     * @return Collection|PaymentTranche[]
     */
    public function getPaymentTranche(): Collection
    {
        return $this->paymentTranche;
    }

    public function addPaymentTranche(PaymentTranche $paymentTranche): self
    {
        if (!$this->paymentTranche->contains($paymentTranche)) {
            $this->paymentTranche[] = $paymentTranche;
            $paymentTranche->setOperation($this);
        }

        return $this;
    }

    public function removePaymentTranche(PaymentTranche $paymentTranche): self
    {
        if ($this->paymentTranche->removeElement($paymentTranche)) {
            // set the owning side to null (unless already changed)
            if ($paymentTranche->getOperation() === $this) {
                $paymentTranche->setOperation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PaymentTrace[]
     */
    public function getPaymentTrace(): Collection
    {
        return $this->paymentTrace;
    }

    public function addPaymentTrace(PaymentTrace $paymentTrace): self
    {
        if (!$this->paymentTrace->contains($paymentTrace)) {
            $this->paymentTrace[] = $paymentTrace;
            $paymentTrace->setOperation($this);
        }

        return $this;
    }

    public function removePaymentTrace(PaymentTrace $paymentTrace): self
    {
        if ($this->paymentTrace->removeElement($paymentTrace)) {
            // set the owning side to null (unless already changed)
            if ($paymentTrace->getOperation() === $this) {
                $paymentTrace->setOperation(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->name;
    }

}
