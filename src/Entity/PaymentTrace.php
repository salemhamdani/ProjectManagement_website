<?php

namespace App\Entity;

use App\Repository\PaymentTraceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaymentTraceRepository::class)
 */
class PaymentTrace
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
     * @ORM\ManyToOne(targetEntity=Operation::class, inversedBy="paymenttrace")
     * @ORM\JoinColumn(nullable=false)
     */
    private $operation;

    /**
     * @ORM\ManyToOne(targetEntity=TraceType::class, inversedBy="paymenttrace")
     * @ORM\JoinColumn(nullable=false)
     */
    private $traceType;

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

    public function getOperation(): ?Operation
    {
        return $this->operation;
    }

    public function setOperation(?Operation $operation): self
    {
        $this->operation = $operation;

        return $this;
    }

    public function getTraceType(): ?TraceType
    {
        return $this->traceType;
    }

    public function setTraceType(?TraceType $traceType): self
    {
        $this->traceType = $traceType;

        return $this;
    }
}
