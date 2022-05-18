<?php

namespace App\Entity;

use App\Repository\IbilbideaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: IbilbideaRepository::class)]
class Ibilbidea
{

    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\ManyToOne(targetEntity: Udala::class, inversedBy: 'ibilbideak')]
    private $udala;

    #[ORM\OneToMany(mappedBy: 'ibilbidea', targetEntity: Mailegua::class)]
    private $maileguak;

    public function __construct()
    {
        $this->maileguak = new ArrayCollection();
    }

    /***************************************************************************************/
    /***************************************************************************************/
    /***************************************************************************************/

    public function __toString()
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
            $maileguak->setIbilbidea($this);
        }

        return $this;
    }

    public function removeMaileguak(Mailegua $maileguak): self
    {
        if ($this->maileguak->removeElement($maileguak)) {
            // set the owning side to null (unless already changed)
            if ($maileguak->getIbilbidea() === $this) {
                $maileguak->setIbilbidea(null);
            }
        }

        return $this;
    }
}
