<?php

namespace App\Entity;

use App\Repository\EguraldiaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: EguraldiaRepository::class)]
class Eguraldia
{

    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $izena;

    /***************************************************************************************/
    /***************************************************************************************/
    /***************************************************************************************/

    public function __toString()
    {
        return $this->izena;
    }

    #[ORM\ManyToOne(targetEntity: Udala::class, inversedBy: 'eguraldiak')]
    private $udala;

    #[ORM\OneToMany(mappedBy: 'eguraldia', targetEntity: Mailegua::class)]
    private $maileguak;

    #[ORM\Column(type: 'integer')]
    private $oldid;

    public function __construct()
    {
        $this->maileguak = new ArrayCollection();
    }

    /***************************************************************************************/
    /***************************************************************************************/
    /***************************************************************************************/

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIzena(): ?string
    {
        return $this->izena;
    }

    public function setIzena(string $izena): self
    {
        $this->izena = $izena;

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
            $maileguak->setEguraldia($this);
        }

        return $this;
    }

    public function removeMaileguak(Mailegua $maileguak): self
    {
        if ($this->maileguak->removeElement($maileguak)) {
            // set the owning side to null (unless already changed)
            if ($maileguak->getEguraldia() === $this) {
                $maileguak->setEguraldia(null);
            }
        }

        return $this;
    }

    public function getOldid(): ?int
    {
        return $this->oldid;
    }

    public function setOldid(int $oldid): self
    {
        $this->oldid = $oldid;

        return $this;
    }
}
