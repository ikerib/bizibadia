<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: ['get'],
//    attributes: [
//        'filters' => ['nan']
//    ],
    denormalizationContext: ['groups' => ['user:list','user:item']],
    normalizationContext: ['groups' => ['user:list','user:item']],
    order: ['name' => 'ASC'],
    paginationEnabled: false
)]
//#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'nan' => 'exact'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use TimestampableEntity;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["user:list", "user:item"])]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Groups(["user:list", "user:item"])]
    private $username;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["user:list", "user:item"])]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\Column(type: 'string', length: 2)]
    private $language='eu';

    #[ORM\Column(type: 'boolean')]
    private $canRent = true;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $bazkidea;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    #[ApiFilter(SearchFilter::class, strategy: 'exact')]
    private $nan;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $ordainketa;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $pasaitarra;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $mugikorra;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $sinatuta;

    #[ORM\Column(type: 'text', nullable: true)]
    private $oharrak;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $alokatua;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $udallangilea;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $baimenberezia;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $iraungitze;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $oldid;

    /*****************************************************************************************************************/
    /*****************************************************************************************************************/
    /*****************************************************************************************************************/

    #[ORM\ManyToOne(targetEntity: Udala::class, inversedBy: 'users')]
    private $udala;

    #[ORM\OneToMany(mappedBy: 'erabiltzailea', targetEntity: Mailegua::class)]
    private $maileguak;

    #[ORM\OneToMany(mappedBy: 'erabiltzailea', targetEntity: ErabiltzaileZigorra::class)]
    #[ORM\OrderBy(['dateEnd' => 'ASC'])]
    private $zigorrak;

    public function __construct()
    {
        $this->maileguak = new ArrayCollection();
        $this->zigorrak = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    /*****************************************************************************************************************/
    /*****************************************************************************************************************/
    /*****************************************************************************************************************/

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

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
            $maileguak->setErabiltzailea($this);
        }

        return $this;
    }

    public function removeMaileguak(Mailegua $maileguak): self
    {
        if ($this->maileguak->removeElement($maileguak)) {
            // set the owning side to null (unless already changed)
            if ($maileguak->getErabiltzailea() === $this) {
                $maileguak->setErabiltzailea(null);
            }
        }

        return $this;
    }

    public function isCanRent(): ?bool
    {
        return $this->canRent;
    }

    public function setCanRent(bool $canRent): self
    {
        $this->canRent = $canRent;

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
            $zigorrak->setErabiltzailea($this);
        }

        return $this;
    }

    public function removeZigorrak(ErabiltzaileZigorra $zigorrak): self
    {
        if ($this->zigorrak->removeElement($zigorrak)) {
            // set the owning side to null (unless already changed)
            if ($zigorrak->getErabiltzailea() === $this) {
                $zigorrak->setErabiltzailea(null);
            }
        }

        return $this;
    }

    public function isBazkidea(): ?bool
    {
        return $this->bazkidea;
    }

    public function setBazkidea(?bool $bazkidea): self
    {
        $this->bazkidea = $bazkidea;

        return $this;
    }

    public function getNan(): ?string
    {
        return $this->nan;
    }

    public function setNan(?string $nan): self
    {
        $this->nan = $nan;

        return $this;
    }

    public function isOrdainketa(): ?bool
    {
        return $this->ordainketa;
    }

    public function setOrdainketa(?bool $ordainketa): self
    {
        $this->ordainketa = $ordainketa;

        return $this;
    }

    public function isPasaitarra(): ?bool
    {
        return $this->pasaitarra;
    }

    public function setPasaitarra(?bool $pasaitarra): self
    {
        $this->pasaitarra = $pasaitarra;

        return $this;
    }

    public function getMugikorra(): ?string
    {
        return $this->mugikorra;
    }

    public function setMugikorra(?string $mugikorra): self
    {
        $this->mugikorra = $mugikorra;

        return $this;
    }

    public function isSinatuta(): ?bool
    {
        return $this->sinatuta;
    }

    public function setSinatuta(?bool $sinatuta): self
    {
        $this->sinatuta = $sinatuta;

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

    public function isAlokatua(): ?bool
    {
        return $this->alokatua;
    }

    public function setAlokatua(?bool $alokatua): self
    {
        $this->alokatua = $alokatua;

        return $this;
    }

    public function isUdallangilea(): ?bool
    {
        return $this->udallangilea;
    }

    public function setUdallangilea(?bool $udallangilea): self
    {
        $this->udallangilea = $udallangilea;

        return $this;
    }

    public function isBaimenberezia(): ?bool
    {
        return $this->baimenberezia;
    }

    public function setBaimenberezia(?bool $baimenberezia): self
    {
        $this->baimenberezia = $baimenberezia;

        return $this;
    }

    public function getIraungitze(): ?\DateTimeInterface
    {
        return $this->iraungitze;
    }

    public function setIraungitze(?\DateTimeInterface $iraungitze): self
    {
        $this->iraungitze = $iraungitze;

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
