<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MaileguaRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MaileguaRepository::class)]
//#[ApiResource(
//    collectionOperations: ['post'],
//    itemOperations: [],
//    denormalizationContext: ['groups' => ['mailegua:write']],
//    normalizationContext: ['groups' => ['mailegua:read']]
//)]
class Mailegua
{

    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['mailegua:list'])]
    private $id;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateStart;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateEnd;

    /***************************************************************************************/
    /***************************************************************************************/
    /***************************************************************************************/

    #[ORM\ManyToOne(targetEntity: Udala::class, inversedBy: 'maileguak')]
    private $udala;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'maileguak')]
    #[Groups(['mailegua:write'])]
    private $erabiltzailea;

    #[ORM\ManyToOne(targetEntity: Bizikleta::class, inversedBy: 'maileguak')]
    private $bizikleta;

    #[ORM\ManyToOne(targetEntity: Eguraldia::class, inversedBy: 'maileguak')]
    private $eguraldia;

    #[ORM\ManyToOne(targetEntity: Ibilbidea::class, inversedBy: 'maileguak')]
    private $ibilbidea;

    #[ORM\ManyToOne(targetEntity: Gunea::class, inversedBy: 'maileguak')]
    private $startGunea;

    #[ORM\ManyToOne(targetEntity: Gunea::class, inversedBy: 'maileguak')]
    private $endGunea;

    #[ORM\ManyToOne(targetEntity: Zigorra::class, inversedBy: 'maileguak')]
    private $zigorra;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $oldid;

    /***************************************************************************************/
    /***************************************************************************************/
    /***************************************************************************************/

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(?\DateTimeInterface $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(?\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

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

    public function getErabiltzailea(): ?User
    {
        return $this->erabiltzailea;
    }

    public function setErabiltzailea(?User $erabiltzailea): self
    {
        $this->erabiltzailea = $erabiltzailea;

        return $this;
    }

    public function getBizikleta(): ?Bizikleta
    {
        return $this->bizikleta;
    }

    public function setBizikleta(?Bizikleta $bizikleta): self
    {
        $this->bizikleta = $bizikleta;

        return $this;
    }

    public function getEguraldia(): ?Eguraldia
    {
        return $this->eguraldia;
    }

    public function setEguraldia(?Eguraldia $eguraldia): self
    {
        $this->eguraldia = $eguraldia;

        return $this;
    }

    public function getIbilbidea(): ?Ibilbidea
    {
        return $this->ibilbidea;
    }

    public function setIbilbidea(?Ibilbidea $ibilbidea): self
    {
        $this->ibilbidea = $ibilbidea;

        return $this;
    }

    public function getStartGunea(): ?Gunea
    {
        return $this->startGunea;
    }

    public function setStartGunea(?Gunea $startGunea): self
    {
        $this->startGunea = $startGunea;

        return $this;
    }

    public function getEndGunea(): ?Gunea
    {
        return $this->endGunea;
    }

    public function setEndGunea(?Gunea $endGunea): self
    {
        $this->endGunea = $endGunea;

        return $this;
    }

    public function getZigorra(): ?Zigorra
    {
        return $this->zigorra;
    }

    public function setZigorra(?Zigorra $zigorra): self
    {
        $this->zigorra = $zigorra;

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
