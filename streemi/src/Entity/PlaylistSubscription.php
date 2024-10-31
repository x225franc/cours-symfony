<?php

namespace App\Entity;

use App\Repository\PlaylistSubscriptionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaylistSubscriptionRepository::class)]
class PlaylistSubscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $subscribedAt = null;

    #[ORM\ManyToOne(inversedBy: 'PlaylistSubscription')]
    private ?User $UserPlaylistSubscription = null;

    #[ORM\ManyToOne(inversedBy: 'playlistSubscriptions')]
    private ?Playlist $Playlist = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubscribedAt(): ?\DateTimeInterface
    {
        return $this->subscribedAt;
    }

    public function setSubscribedAt(\DateTimeInterface $subscribedAt): static
    {
        $this->subscribedAt = $subscribedAt;

        return $this;
    }

    public function getUserPlaylistSubscription(): ?User
    {
        return $this->UserPlaylistSubscription;
    }

    public function setUserPlaylistSubscription(?User $UserPlaylistSubscription): static
    {
        $this->UserPlaylistSubscription = $UserPlaylistSubscription;

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
}
