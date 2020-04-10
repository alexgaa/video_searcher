<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserDataRepository")
 */
class UserData
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255,unique=true)
     */
    private $name_user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $user_ip;

    /**
     * @ORM\Column(type="text")
     */
    private $browser;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\InputUrl", mappedBy="id_user")
     */
    private $inputUrls;

    public function __construct()
    {
        $this->inputUrls = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameUser(): ?string
    {
        return $this->name_user;
    }

    public function setNameUser(string $name_user): self
    {
        $this->name_user = $name_user;

        return $this;
    }

    public function getUserIp(): ?string
    {
        return $this->user_ip;
    }

    public function setUserIp(?string $user_ip): self
    {
        $this->user_ip = $user_ip;

        return $this;
    }

    public function getBrowser(): ?string
    {
        return $this->browser;
    }

    public function setBrowser(?string $browser): self
    {
        $this->browser = $browser;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|InputUrl[]
     */
    public function getInputUrls(): Collection
    {
        return $this->inputUrls;
    }

    public function addInputUrl(InputUrl $inputUrl): self
    {
        if (!$this->inputUrls->contains($inputUrl)) {
            $this->inputUrls[] = $inputUrl;
            $inputUrl->setIdUser($this);
        }

        return $this;
    }

    public function removeInputUrl(InputUrl $inputUrl): self
    {
        if ($this->inputUrls->contains($inputUrl)) {
            $this->inputUrls->removeElement($inputUrl);
            // set the owning side to null (unless already changed)
            if ($inputUrl->getIdUser() === $this) {
                $inputUrl->setIdUser(null);
            }
        }

        return $this;
    }
}
