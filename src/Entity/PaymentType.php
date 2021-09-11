<?php

namespace App\Entity;

use App\Repository\PaymentTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaymentTypeRepository::class)
 */
class PaymentType
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
     * @ORM\Column(type="float", nullable=true)
     */
    private $limitation;

    /**
     * @ORM\OneToMany(targetEntity=PaymentTranche::class, mappedBy="paymenttype", orphanRemoval=true)
     */
    private $paymentTranches;

    public function __construct()
    {
        $this->paymentTranches = new ArrayCollection();
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

    public function getLimitation(): ?float
    {
        return $this->limitation;
    }

    public function setLimitation(?float $limitation): self
    {
        $this->limitation = $limitation;

        return $this;
    }

    /**
     * @return Collection|PaymentTranche[]
     */
    public function getPaymentTranches(): Collection
    {
        return $this->paymentTranches;
    }

    public function addPaymentTranch(PaymentTranche $paymentTranch): self
    {
        if (!$this->paymentTranches->contains($paymentTranch)) {
            $this->paymentTranches[] = $paymentTranch;
            $paymentTranch->setPaymenttype($this);
        }

        return $this;
    }

    public function removePaymentTranch(PaymentTranche $paymentTranch): self
    {
        if ($this->paymentTranches->removeElement($paymentTranch)) {
            // set the owning side to null (unless already changed)
            if ($paymentTranch->getPaymenttype() === $this) {
                $paymentTranch->setPaymenttype(null);
            }
        }

        return $this;
    }
    public function __toString()
{
    return $this->name;
}
}
