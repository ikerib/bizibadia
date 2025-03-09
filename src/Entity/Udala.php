<?php

namespace App\Entity;

use App\Repository\UdalaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: UdalaRepository::class)]
class Udala
{
    use TimestampableEntity;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'udala', targetEntity: User::class)]
    private $users;

    #[ORM\OneToMany(mappedBy: 'udala', targetEntity: Gunea::class)]
    private $guneak;

    #[ORM\OneToMany(mappedBy: 'udala', targetEntity: Bizikleta::class)]
    private $bizikletak;

    #[ORM\OneToMany(mappedBy: 'udala', targetEntity: Ibilbidea::class)]
    private $ibilbideak;

    #[ORM\OneToMany(mappedBy: 'udala', targetEntity: Eguraldia::class)]
    private $eguraldiak;

    #[ORM\OneToMany(mappedBy: 'udala', targetEntity: Zigorra::class)]
    private $zigorrak;

    #[ORM\OneToMany(mappedBy: 'udala', targetEntity: Mailegua::class)]
    private $maileguak;

    /************************************************************************************************/
    /************************************************************************************************/
    /************************************************************************************************/

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->guneak = new ArrayCollection();
        $this->bizikletak = new ArrayCollection();
        $this->ibilbideak = new ArrayCollection();
        $this->eguraldiak = new ArrayCollection();
        $this->zigorrak = new ArrayCollection();
        $this->maileguak = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
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
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setUdala($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getUdala() === $this) {
                $user->setUdala(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Gunea>
     */
    public function getGuneak(): Collection
    {
        return $this->guneak;
    }

    public function addGuneak(Gunea $guneak): self
    {
        if (!$this->guneak->contains($guneak)) {
            $this->guneak->add($guneak);
            $guneak->setUdala($this);
        }

        return $this;
    }

    public function removeGuneak(Gunea $guneak): self
    {
        if ($this->guneak->removeElement($guneak)) {
            // set the owning side to null (unless already changed)
            if ($guneak->getUdala() === $this) {
                $guneak->setUdala(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Bizikleta>
     */
    public function getBizikletak(): Collection
    {
        return $this->bizikletak;
    }

    public function addBizikletak(Bizikleta $bizikletak): self
    {
        if (!$this->bizikletak->contains($bizikletak)) {
            $this->bizikletak->add($bizikletak);
            $bizikletak->setUdala($this);
        }

        return $this;
    }

    public function removeBizikletak(Bizikleta $bizikletak): self
    {
        if ($this->bizikletak->removeElement($bizikletak)) {
            // set the owning side to null (unless already changed)
            if ($bizikletak->getUdala() === $this) {
                $bizikletak->setUdala(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ibilbidea>
     */
    public function getIbilbideak(): Collection
    {
        return $this->ibilbideak;
    }

    public function addIbilbideak(Ibilbidea $ibilbideak): self
    {
        if (!$this->ibilbideak->contains($ibilbideak)) {
            $this->ibilbideak->add($ibilbideak);
            $ibilbideak->setUdala($this);
        }

        return $this;
    }

    public function removeIbilbideak(Ibilbidea $ibilbideak): self
    {
        if ($this->ibilbideak->removeElement($ibilbideak)) {
            // set the owning side to null (unless already changed)
            if ($ibilbideak->getUdala() === $this) {
                $ibilbideak->setUdala(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Eguraldia>
     */
    public function getEguraldiak(): Collection
    {
        return $this->eguraldiak;
    }

    public function addEguraldiak(Eguraldia $eguraldiak): self
    {
        if (!$this->eguraldiak->contains($eguraldiak)) {
            $this->eguraldiak->add($eguraldiak);
            $eguraldiak->setUdala($this);
        }

        return $this;
    }

    public function removeEguraldiak(Eguraldia $eguraldiak): self
    {
        if ($this->eguraldiak->removeElement($eguraldiak)) {
            // set the owning side to null (unless already changed)
            if ($eguraldiak->getUdala() === $this) {
                $eguraldiak->setUdala(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Zigorra>
     */
    public function getZigorrak(): Collection
    {
        return $this->zigorrak;
    }

    public function addZigorrak(Zigorra $zigorrak): self
    {
        if (!$this->zigorrak->contains($zigorrak)) {
            $this->zigorrak->add($zigorrak);
            $zigorrak->setUdala($this);
        }

        return $this;
    }

    public function removeZigorrak(Zigorra $zigorrak): self
    {
        if ($this->zigorrak->removeElement($zigorrak)) {
            // set the owning side to null (unless already changed)
            if ($zigorrak->getUdala() === $this) {
                $zigorrak->setUdala(null);
            }
        }

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
            $this->maileguak->add($maileguak);
            $maileguak->setUdala($this);
        }

        return $this;
    }

    public function removeMaileguak(Mailegua $maileguak): self
    {
        if ($this->maileguak->removeElement($maileguak)) {
            // set the owning side to null (unless already changed)
            if ($maileguak->getUdala() === $this) {
                $maileguak->setUdala(null);
            }
        }

        return $this;
    }
}
