<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VideoDataRepository")
 */
class VideoData
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\InputUrl", inversedBy="videoData")
     * @ORM\JoinColumn(nullable=false)
     */
    private $input_url;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $id_video;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img_site;

    /**
     * @ORM\Column(type="text")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     */
    private $img_youtube;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $valid;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInputUrl(): ?InputUrl
    {
        return $this->input_url;
    }

    public function setInputUrl(?InputUrl $input_url): self
    {
        $this->input_url = $input_url;

        return $this;
    }

    public function getIdVideo(): ?string
    {
        return $this->id_video;
    }

    public function setIdVideo(string $id_video): self
    {
        $this->id_video = $id_video;

        return $this;
    }

    public function getImgSite(): ?string
    {
        return $this->img_site;
    }

    public function setImgSite(string $img_site): self
    {
        $this->img_site = $img_site;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImgYoutube(): ?string
    {
        return $this->img_youtube;
    }

    public function setImgYoutube(string $img_youtube): self
    {
        $this->img_youtube = $img_youtube;

        return $this;
    }

    public function getValid(): ?string
    {
        return $this->valid;
    }

    public function setValid(string $valid): self
    {
        $this->valid = $valid;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
