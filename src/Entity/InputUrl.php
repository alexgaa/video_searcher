<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InputUrlRepository")
 */
class InputUrl
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\UserData", inversedBy="inputUrls")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     *
     * @ORM\Column(type="string", length=50)
     */
    private $url_key;

    /**
     * @ORM\Column(type="text")
     */
    private $url;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VideoData", mappedBy="input_url")
     */
    private $videoData;

    public function __construct($user,$url_key)
    {
        $this->user=$user;
        $this->url_key=$url_key;
        $this->videoData = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?UserData
    {
        return $this->user;
    }

    public function setUser(?UserData $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getUrlKey(): ?string
    {
        return $this->url_key;
    }

    public function setUrlKey(string $url_key): self
    {
        $this->url_key = $url_key;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

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
     * @return Collection|VideoData[]
     */
    public function getVideoData(): Collection
    {
        return $this->videoData;
    }

    public function addVideoData(VideoData $videoData): self
    {
        if (!$this->videoData->contains($videoData)) {
            $this->videoData[] = $videoData;
            $videoData->setInputUrl($this);
        }

        return $this;
    }

    public function removeVideoData(VideoData $videoData): self
    {
        if ($this->videoData->contains($videoData)) {
            $this->videoData->removeElement($videoData);
            // set the owning side to null (unless already changed)
            if ($videoData->getInputUrl() === $this) {
                $videoData->setInputUrl(null);
            }
        }

        return $this;
    }
}
