<?php

namespace App\Entity;

use App\Repository\PlaylistMediaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaylistMediaRepository::class)]
class PlaylistMedia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $addedAt = null;

    #[ORM\ManyToOne(inversedBy: 'MediaPlaylist')]
    private ?Playlist $Playlist = null;

    #[ORM\ManyToOne(inversedBy: 'playlistMedia')]
    private ?Media $Media = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddedAt(): ?\DateTimeInterface
    {
        return $this->addedAt;
    }

    public function setAddedAt(\DateTimeInterface $addedAt): static
    {
        $this->addedAt = $addedAt;

        return $this;
    }

    public function getPlaylist(): ?Playlist
    {
        return $this->Playlist;
    }

    public function setPlaylist(?Playlist $Playlist): static
    {
        $this->Playlist = $Playlist;

        return $this;
    }

    public function getMedia(): ?Media
    {
        return $this->Media;
    }

    public function setMedia(?Media $Media): static
    {
        $this->Media = $Media;

        return $this;
    }
}
