<?php

namespace App\Entity;

use App\Enum\MediaTypeEnum;
use App\Repository\MediaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
class Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: MediaTypeEnum::class)]
    private ?MediaTypeEnum $mediaType = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $shortDescription = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $longDescription = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $releaseDate = null;

    #[ORM\Column(length: 255)]
    private ?string $coverImage = null;

    #[ORM\Column]
    private array $staff = [];

    #[ORM\Column]
    private array $casting = [];

    /**
     * @var Collection<int, Playlist>
     */
    #[ORM\ManyToMany(targetEntity: Playlist::class, mappedBy: 'Media')]
    private Collection $MediaPlaylist;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'Media')]
    private Collection $comments;

    /**
     * @var Collection<int, WatchHistory>
     */
    #[ORM\OneToMany(targetEntity: WatchHistory::class, mappedBy: 'Media')]
    private Collection $watchHistories;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'media')]
    private Collection $Category;

    /**
     * @var Collection<int, Language>
     */
    #[ORM\ManyToMany(targetEntity: Language::class, inversedBy: 'media')]
    private Collection $Language;

    /**
     * @var Collection<int, PlaylistMedia>
     */
    #[ORM\OneToMany(targetEntity: PlaylistMedia::class, mappedBy: 'media')]
private Collection $playlistMedia;

    /**
     * @var Collection<int, Cast>
     */
    #[ORM\ManyToMany(targetEntity: Cast::class, mappedBy: 'Casting')]
    private Collection $casts;

    public function __construct()
    {
        $this->MediaPlaylist = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->watchHistories = new ArrayCollection();
        $this->Category = new ArrayCollection();
        $this->Language = new ArrayCollection();
        $this->playlistMedia = new ArrayCollection();
        $this->casts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMediaType(): ?MediaTypeEnum
    {
        return $this->mediaType;
    }

    public function setMediaType(MediaTypeEnum $mediaType): static
    {
        $this->mediaType = $mediaType;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(string $shortDescription): static
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function getLongDescription(): ?string
    {
        return $this->longDescription;
    }

    public function setLongDescription(string $longDescription): static
    {
        $this->longDescription = $longDescription;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTimeInterface $releaseDate): static
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(string $coverImage): static
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    public function getStaff(): array
    {
        return $this->staff;
    }

    public function setStaff(array $staff): static
    {
        $this->staff = $staff;

        return $this;
    }

    public function getCasting(): array
    {
        return $this->casting;
    }

    public function setCasting(array $casting): static
    {
        $this->casting = $casting;

        return $this;
    }

    /**
     * @return Collection<int, Playlist>
     */
    public function getMediaPlaylist(): Collection
    {
        return $this->MediaPlaylist;
    }

    public function addMediaPlaylist(Playlist $mediaPlaylist): static
    {
        if (!$this->MediaPlaylist->contains($mediaPlaylist)) {
            $this->MediaPlaylist->add($mediaPlaylist);
            $mediaPlaylist->addMedium($this);
        }

        return $this;
    }

    public function removeMediaPlaylist(Playlist $mediaPlaylist): static
    {
        if ($this->MediaPlaylist->removeElement($mediaPlaylist)) {
            $mediaPlaylist->removeMedium($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setMedia($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getMedia() === $this) {
                $comment->setMedia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, WatchHistory>
     */
    public function getWatchHistories(): Collection
    {
        return $this->watchHistories;
    }

    public function addWatchHistory(WatchHistory $watchHistory): static
    {
        if (!$this->watchHistories->contains($watchHistory)) {
            $this->watchHistories->add($watchHistory);
            $watchHistory->setMedia($this);
        }

        return $this;
    }

    public function removeWatchHistory(WatchHistory $watchHistory): static
    {
        if ($this->watchHistories->removeElement($watchHistory)) {
            // set the owning side to null (unless already changed)
            if ($watchHistory->getMedia() === $this) {
                $watchHistory->setMedia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategory(): Collection
    {
        return $this->Category;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->Category->contains($category)) {
            $this->Category->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->Category->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, Language>
     */
    public function getLanguage(): Collection
    {
        return $this->Language;
    }

    public function addLanguage(Language $language): static
    {
        if (!$this->Language->contains($language)) {
            $this->Language->add($language);
        }

        return $this;
    }

    public function removeLanguage(Language $language): static
    {
        $this->Language->removeElement($language);

        return $this;
    }

    /**
     * @return Collection<int, PlaylistMedia>
     */
    public function getPlaylistMedia(): Collection
    {
        return $this->playlistMedia;
    }

    public function addPlaylistMedium(PlaylistMedia $playlistMedium): static
    {
        if (!$this->playlistMedia->contains($playlistMedium)) {
            $this->playlistMedia->add($playlistMedium);
            $playlistMedium->setMedia($this);
        }

        return $this;
    }

    public function removePlaylistMedium(PlaylistMedia $playlistMedium): static
    {
        if ($this->playlistMedia->removeElement($playlistMedium)) {
            // set the owning side to null (unless already changed)
            if ($playlistMedium->getMedia() === $this) {
                $playlistMedium->setMedia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Cast>
     */
    public function getCasts(): Collection
    {
        return $this->casts;
    }

    public function addCast(Cast $cast): static
    {
        if (!$this->casts->contains($cast)) {
            $this->casts->add($cast);
            $cast->addCasting($this);
        }

        return $this;
    }

    public function removeCast(Cast $cast): static
    {
        if ($this->casts->removeElement($cast)) {
            $cast->removeCasting($this);
        }

        return $this;
    }
}
