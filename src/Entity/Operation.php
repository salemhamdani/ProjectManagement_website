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
    private $budgetline;

    /**
     * @ORM\OneToMany(targetEntity=PaymentTranche::class, mappedBy="yes", orphanRemoval=true)
     */
    private $paymenttranche;

    /**
     * @ORM\OneToMany(targetEntity=PaymentTrace::class, mappedBy="yes", orphanRemoval=true)
     */
    private $paymenttrace;

    public function __construct()
    {
        $this->paymenttranche = new ArrayCollection();
        $this->paymenttrace = new ArrayCollection();
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

    public function getBudgetline(): ?BudgetLine
    {
        return $this->budgetline;
    }

    public function setBudgetline(?BudgetLine $budgetline): self
    {
        $this->budgetline = $budgetline;

        return $this;
    }

    /**
     * @return Collection|PaymentTranche[]
     */
    public function getPaymenttranche(): Collection
    {
        return $this->paymenttranche;
    }

    public function addPaymenttranche(PaymentTranche $paymenttranche): self
    {
        if (!$this->paymenttranche->contains($paymenttranche)) {
            $this->paymenttranche[] = $paymenttranche;
            $paymenttranche->setOperation($this);
        }

        return $this;
    }

    public function removePaymenttranche(PaymentTranche $paymenttranche): self
    {
        if ($this->paymenttranche->removeElement($paymenttranche)) {
            // set the owning side to null (unless already changed)
            if ($paymenttranche->getOperation() === $this) {
                $paymenttranche->setOperation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PaymentTrace[]
     */
    public function getPaymenttrace(): Collection
    {
        return $this->paymenttrace;
    }

    public function addPaymenttrace(PaymentTrace $paymenttrace): self
    {
        if (!$this->paymenttrace->contains($paymenttrace)) {
            $this->paymenttrace[] = $paymenttrace;
            $paymenttrace->setOperation($this);
        }

        return $this;
    }

    public function removePaymenttrace(PaymentTrace $paymenttrace): self
    {
        if ($this->paymenttrace->removeElement($paymenttrace)) {
            // set the owning side to null (unless already changed)
            if ($paymenttrace->getOperation() === $this) {
                $paymenttrace->setOperation(null);
            }
        }

        return $this;
    }
}
