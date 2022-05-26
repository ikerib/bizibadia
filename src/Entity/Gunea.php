<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GuneaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GuneaRepository::class)]
#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: ['get'],
    normalizationContext: ['groups' => ['gunea:list']],
    order: ['name' => 'ASC'],
    paginationEnabled: false
)]
class Gunea
{
    use TimestampableEntity;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["gunea:list"])]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["gunea:list"])]
    private $helbidea;

    #[ORM\Column(type: 'text', length: 255)]
    #[Groups(["gunea:list"])]
    private $ordutegia;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups(["gunea:list"])]
    private $latitude;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups(["gunea:list"])]
    private $longitude;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $oldid;

    /***************************************************************************************/
    /***************************************************************************************/
    /***************************************************************************************/

    #[ORM\ManyToOne(targetEntity: Udala::class, inversedBy: 'guneak')]
    private $udala;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $manager;

    #[ORM\OneToMany(mappedBy: 'gunea', targetEntity: Bizikleta::class)]
    private $bizikletak;

    #[ORM\OneToMany(mappedBy: 'startGunea', targetEntity: Mailegua::class)]
    private $maileguak;



    public function __construct()
    {
        $this->bizikletak = new ArrayCollection();
        $this->maileguak = new ArrayCollection();
    }

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

    public function getHelbidea(): ?string
    {
        return $this->helbidea;
    }

    public function setHelbidea(string $helbidea): self
    {
        $this->helbidea = $helbidea;

        return $this;
    }

    public function getOrdutegia(): ?string
    {
        return $this->ordutegia;
    }

    public function setOrdutegia(string $ordutegia): self
    {
        $this->ordutegia = $ordutegia;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

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

    public function getManager(): ?User
    {
        return $this->manager;
    }

    public function setManager(?User $manager): self
    {
        $this->manager = $manager;

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
            $this->bizikletak[] = $bizikletak;
            $bizikletak->setGunea($this);
        }

        return $this;
    }

    public function removeBizikletak(Bizikleta $bizikletak): self
    {
        if ($this->bizikletak->removeElement($bizikletak)) {
            // set the owning side to null (unless already changed)
            if ($bizikletak->getGunea() === $this) {
                $bizikletak->setGunea(null);
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
            $this->maileguak[] = $maileguak;
            $maileguak->setStartGunea($this);
        }

        return $this;
    }

    public function removeMaileguak(Mailegua $maileguak): self
    {
        if ($this->maileguak->removeElement($maileguak)) {
            // set the owning side to null (unless already changed)
            if ($maileguak->getStartGunea() === $this) {
                $maileguak->setStartGunea(null);
            }
        }

        return $this;
    }

    public function getOldid(): ?int
    {
        return $this->oldid;
    }

    public function setOldid(?int $oldid): self
    {
        $this->oldid = $oldid;

        return $this;
    }
}
