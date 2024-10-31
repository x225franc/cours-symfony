<?php

namespace App\Entity;

use App\Enum\UserAccountStatusEnum;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(enumType: UserAccountStatusEnum::class)]
    private ?UserAccountStatusEnum $accountStatus = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Subscription $Subscription = null;

    /**
     * @var Collection<int, SubscriptionHistory>
     */
    #[ORM\OneToMany(targetEntity: SubscriptionHistory::class, mappedBy: 'SubHistory')]
    private Collection $SubscriptionHistory;

    /**
     * @var Collection<int, Playlist>
     */
    #[ORM\OneToMany(targetEntity: Playlist::class, mappedBy: 'userPlaylist')]
    private Collection $Playlist;

    /**
     * @var Collection<int, WatchHistory>
     */
    #[ORM\OneToMany(targetEntity: WatchHistory::class, mappedBy: 'userWatchHistory')]
    private Collection $WatchHistory;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'UserComment')]
    private Collection $Comment;

    /**
     * @var Collection<int, PlaylistSubscription>
     */
    #[ORM\OneToMany(targetEntity: PlaylistSubscription::class, mappedBy: 'UserPlaylistSubscription')]
    private Collection $PlaylistSubscription;

    public function __construct()
    {
        $this->SubscriptionHistory = new ArrayCollection();
        $this->Playlist = new ArrayCollection();
        $this->WatchHistory = new ArrayCollection();
        $this->Comment = new ArrayCollection();
        $this->PlaylistSubscription = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getAccountStatus(): ?UserAccountStatusEnum
    {
        return $this->accountStatus;
    }

    public function setAccountStatus(UserAccountStatusEnum $accountStatus): static
    {
        $this->accountStatus = $accountStatus;

        return $this;
    }

    public function getSubscription(): ?Subscription
    {
        return $this->Subscription;
    }

    public function setSubscription(?Subscription $Subscription): static
    {
        $this->Subscription = $Subscription;

        return $this;
    }

    /**
     * @return Collection<int, SubscriptionHistory>
     */
    public function getSubscriptionHistory(): Collection
    {
        return $this->SubscriptionHistory;
    }

    public function addSubscriptionHistory(SubscriptionHistory $subscriptionHistory): static
    {
        if (!$this->SubscriptionHistory->contains($subscriptionHistory)) {
            $this->SubscriptionHistory->add($subscriptionHistory);
            $subscriptionHistory->setSubHistory($this);
        }

        return $this;
    }

    public function removeSubscriptionHistory(SubscriptionHistory $subscriptionHistory): static
    {
        if ($this->SubscriptionHistory->removeElement($subscriptionHistory)) {
            // set the owning side to null (unless already changed)
            if ($subscriptionHistory->getSubHistory() === $this) {
                $subscriptionHistory->setSubHistory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Playlist>
     */
    public function getPlaylist(): Collection
    {
        return $this->Playlist;
    }

    public function addPlaylist(Playlist $playlist): static
    {
        if (!$this->Playlist->contains($playlist)) {
            $this->Playlist->add($playlist);
            $playlist->setUserPlaylist($this);
        }

        return $this;
    }

    public function removePlaylist(Playlist $playlist): static
    {
        if ($this->Playlist->removeElement($playlist)) {
            // set the owning side to null (unless already changed)
            if ($playlist->getUserPlaylist() === $this) {
                $playlist->setUserPlaylist(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, WatchHistory>
     */
    public function getWatchHistory(): Collection
    {
        return $this->WatchHistory;
    }

    public function addWatchHistory(WatchHistory $watchHistory): static
    {
        if (!$this->WatchHistory->contains($watchHistory)) {
            $this->WatchHistory->add($watchHistory);
            $watchHistory->setUserWatchHistory($this);
        }

        return $this;
    }

    public function removeWatchHistory(WatchHistory $watchHistory): static
    {
        if ($this->WatchHistory->removeElement($watchHistory)) {
            // set the owning side to null (unless already changed)
            if ($watchHistory->getUserWatchHistory() === $this) {
                $watchHistory->setUserWatchHistory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComment(): Collection
    {
        return $this->Comment;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->Comment->contains($comment)) {
            $this->Comment->add($comment);
            $comment->setUserComment($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->Comment->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUserComment() === $this) {
                $comment->setUserComment(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PlaylistSubscription>
     */
    public function getPlaylistSubscription(): Collection
    {
        return $this->PlaylistSubscription;
    }

    public function addPlaylistSubscription(PlaylistSubscription $playlistSubscription): static
    {
        if (!$this->PlaylistSubscription->contains($playlistSubscription)) {
            $this->PlaylistSubscription->add($playlistSubscription);
            $playlistSubscription->setUserPlaylistSubscription($this);
        }

        return $this;
    }

    public function removePlaylistSubscription(PlaylistSubscription $playlistSubscription): static
    {
        if ($this->PlaylistSubscription->removeElement($playlistSubscription)) {
            // set the owning side to null (unless already changed)
            if ($playlistSubscription->getUserPlaylistSubscription() === $this) {
                $playlistSubscription->setUserPlaylistSubscription(null);
            }
        }

        return $this;
    }
}
