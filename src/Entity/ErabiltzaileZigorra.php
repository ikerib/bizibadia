<?php

namespace App\Entity;

use App\Repository\ErabiltzaileZigorraRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: ErabiltzaileZigorraRepository::class)]
class ErabiltzaileZigorra
{

    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date', nullable: true)]
    private $dateStart;

    #[ORM\Column(type: 'date', nullable: true)]
    private $dateEnd;

    /***************************************************************************************/
    /***************************************************************************************/
    /***************************************************************************************/

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'zigorrak')]
    private $erabiltzailea;

    #[ORM\ManyToOne(targetEntity: Zigorra::class, inversedBy: 'zigorrak')]
    private $zigorra;

    /***************************************************************************************/
    /***************************************************************************************/
    /***************************************************************************************/

    public function getId(): ?int
    {
        return $this->id;
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

    public function getZigorra(): ?Zigorra
    {
        return $this->zigorra;
    }

    public function setZigorra(?Zigorra $zigorra): self
    {
        $this->zigorra = $zigorra;

        return $this;
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
}
