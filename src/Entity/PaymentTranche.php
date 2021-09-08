<?php

namespace App\Entity;

use App\Repository\PaymentTrancheRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaymentTrancheRepository::class)
 */
class PaymentTranche
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity=Operation::class, inversedBy="paymenttranche")
     * @ORM\JoinColumn(nullable=false)
     */
    private $operation;

    /**
     * @ORM\ManyToOne(targetEntity=PaymentType::class, inversedBy="paymentTranches")
     * @ORM\JoinColumn(nullable=false)
     */
    private $paymenttype;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getOperation(): ?Operation
    {
        return $this->operation;
    }

    public function setOperation(?Operation $operation): self
    {
        $this->operation = $operation;

        return $this;
    }

    public function getPaymenttype(): ?PaymentType
    {
        return $this->paymenttype;
    }

    public function setPaymenttype(?PaymentType $paymenttype): self
    {
        $this->paymenttype = $paymenttype;

        return $this;
    }
}
