<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BizikletaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BizikletaRepository::class)]
#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: ['get'],
    normalizationContext: ['groups' => ['bizikleta:list']],

)]
class Bizikleta
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["bizikleta:list"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["bizikleta:list"])]
    private $code;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["bizikleta:list"])]
    private $erregistroa;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["bizikleta:list"])]
    private $bastidorea;

    #[ORM\Column(type: 'boolean')]
    #[Groups(["bizikleta:list"])]
    private $isAlokatuta;

    /***************************************************************************************/
    /***************************************************************************************/
    /***************************************************************************************/

    #[ORM\ManyToOne(targetEntity: Udala::class, inversedBy: 'bizikletak')]
    private $udala;

    #[ORM\ManyToOne(targetEntity: Gunea::class, inversedBy: 'bizikletak')]
    #[Groups(["bizikleta:list"])]
    private $gunea;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(["bizikleta:list"])]
    private $notes;

    #[ORM\OneToMany(mappedBy: 'bizikleta', targetEntity: Mailegua::class)]
    private $maileguak;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $oldid;

    public function __construct()
    {
        $this->maileguak = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->code;
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getErregistroa(): ?string
    {
        return $this->erregistroa;
    }

    public function setErregistroa(?string $erregistroa): self
    {
        $this->erregistroa = $erregistroa;

        return $this;
    }

    public function getBastidorea(): ?string
    {
        return $this->bastidorea;
    }

    public function setBastidorea(string $bastidorea): self
    {
        $this->bastidorea = $bastidorea;

        return $this;
    }

    public function getEzaugarriak(): ?string
    {
        return $this->ezaugarriak;
    }

    public function setEzaugarriak(?string $ezaugarriak): self
    {
        $this->ezaugarriak = $ezaugarriak;

        return $this;
    }

    public function getOharrak(): ?string
    {
        return $this->oharrak;
    }

    public function setOharrak(?string $oharrak): self
    {
        $this->oharrak = $oharrak;

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

    public function getGunea(): ?Gunea
    {
        return $this->gunea;
    }

    public function setGunea(?Gunea $gunea): self
    {
        $this->gunea = $gunea;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

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
            $maileguak->setBizikleta($this);
        }

        return $this;
    }

    public function removeMaileguak(Mailegua $maileguak): self
    {
        if ($this->maileguak->removeElement($maileguak)) {
            // set the owning side to null (unless already changed)
            if ($maileguak->getBizikleta() === $this) {
                $maileguak->setBizikleta(null);
            }
        }

        return $this;
    }

    public function isIsAlokatuta(): ?bool
    {
        return $this->isAlokatuta;
    }

    public function setIsAlokatuta(bool $isAlokatuta): self
    {
        $this->isAlokatuta = $isAlokatuta;

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
