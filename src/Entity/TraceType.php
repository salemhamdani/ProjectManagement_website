<?php

namespace App\Entity;

use App\Repository\TraceTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TraceTypeRepository::class)
 */
class TraceType
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
     * @ORM\OneToMany(targetEntity=PaymentTrace::class, mappedBy="traceType", orphanRemoval=true)
     */
    private $paymentTrace;

    public function __construct()
    {
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
            $paymentTrace->setTraceType($this);
        }

        return $this;
    }

    public function removePaymentTrace(PaymentTrace $paymentTrace): self
    {
        if ($this->paymentTrace->removeElement($paymentTrace)) {
            // set the owning side to null (unless already changed)
            if ($paymentTrace->getTraceType() === $this) {
                $paymentTrace->setTraceType(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->name;
    }
}
