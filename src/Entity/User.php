<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use TimestampableEntity;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $username;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $surname;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\Column(type: 'string', length: 2)]
    private $language='eu';

    #[ORM\Column(type: 'boolean')]
    private $canRent = true;

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
        return $this->name . ' ' . $this->surname;
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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

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
}
