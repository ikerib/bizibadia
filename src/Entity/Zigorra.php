<?php

namespace App\Entity;

use App\Repository\ZigorraRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: ZigorraRepository::class)]
class Zigorra
{

    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private $deskribapena;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $maila;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $egunak;

    #[ORM\Column(type: 'float', nullable: true)]
    private $zenbatekoa;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $canRent;

    /***************************************************************************************/
    /***************************************************************************************/
    /***************************************************************************************/

    #[ORM\ManyToOne(targetEntity: Udala::class, inversedBy: 'zigorrak')]
    private $udala;

    #[ORM\OneToMany(mappedBy: 'zigorra', targetEntity: Mailegua::class)]
    private $maileguak;

    #[ORM\OneToMany(mappedBy: 'zigorra', targetEntity: ErabiltzaileZigorra::class)]
    private $zigorrak;

    public function __construct()
    {
        $this->maileguak = new ArrayCollection();
        $this->zigorrak = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    /***************************************************************************************/
    /***************************************************************************************/
    /***************************************************************************************/

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

    public function getUdala(): ?Udala
    {
        return $this->udala;
    }

    public function setUdala(?Udala $udala): self
    {
        $this->udala = $udala;

        return $this;
    }

    /**
     * @return Collection<int, Mailegua>
     */
    public function getMaileguak(): Collection
    {
        return $this->maileguak;
    }

    public function addMaileguak(Mailegua $maileguak): self
    {
        if (!$this->maileguak->contains($maileguak)) {
            $this->maileguak[] = $maileguak;
            $maileguak->setZigorra($this);
        }

        return $this;
    }

    public function removeMaileguak(Mailegua $maileguak): self
    {
        if ($this->maileguak->removeElement($maileguak)) {
            // set the owning side to null (unless already changed)
            if ($maileguak->getZigorra() === $this) {
                $maileguak->setZigorra(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ErabiltzaileZigorra>
     */
    public function getZigorrak(): Collection
    {
        return $this->zigorrak;
    }

    public function addZigorrak(ErabiltzaileZigorra $zigorrak): self
    {
        if (!$this->zigorrak->contains($zigorrak)) {
            $this->zigorrak[] = $zigorrak;
            $zigorrak->setZigorra($this);
        }

        return $this;
    }

    public function removeZigorrak(ErabiltzaileZigorra $zigorrak): self
    {
        if ($this->zigorrak->removeElement($zigorrak)) {
            // set the owning side to null (unless already changed)
            if ($zigorrak->getZigorra() === $this) {
                $zigorrak->setZigorra(null);
            }
        }

        return $this;
    }

    public function getDeskribapena(): ?string
    {
        return $this->deskribapena;
    }

    public function setDeskribapena(?string $deskribapena): self
    {
        $this->deskribapena = $deskribapena;

        return $this;
    }

    public function getMaila(): ?string
    {
        return $this->maila;
    }

    public function setMaila(?string $maila): self
    {
        $this->maila = $maila;

        return $this;
    }

    public function getEgunak(): ?int
    {
        return $this->egunak;
    }

    public function setEgunak(?int $egunak): self
    {
        $this->egunak = $egunak;

        return $this;
    }

    public function getZenbatekoa(): ?float
    {
        return $this->zenbatekoa;
    }

    public function setZenbatekoa(?float $zenbatekoa): self
    {
        $this->zenbatekoa = $zenbatekoa;

        return $this;
    }

    public function isCanRent(): ?bool
    {
        return $this->canRent;
    }

    public function setCanRent(?bool $canRent): self
    {
        $this->canRent = $canRent;

        return $this;
    }
}
