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
    private $paymenttrace;

    public function __construct()
    {
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
            $paymenttrace->setTraceType($this);
        }

        return $this;
    }

    public function removePaymenttrace(PaymentTrace $paymenttrace): self
    {
        if ($this->paymenttrace->removeElement($paymenttrace)) {
            // set the owning side to null (unless already changed)
            if ($paymenttrace->getTraceType() === $this) {
                $paymenttrace->setTraceType(null);
            }
        }

        return $this;
    }
}
