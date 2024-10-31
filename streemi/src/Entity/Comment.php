<?php

namespace App\Entity;

use App\Enum\CommentStatusEnum;
use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(enumType: CommentStatusEnum::class)]
    private ?CommentStatusEnum $status = null;

    #[ORM\ManyToOne(inversedBy: 'Comment')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $UserComment = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Media $Media = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?self $Comment = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'Comment')]
    private Collection $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getStatus(): ?CommentStatusEnum
    {
        return $this->status;
    }

    public function setStatus(CommentStatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getUserComment(): ?User
    {
        return $this->UserComment;
    }

    public function setUserComment(?User $UserComment): static
    {
        $this->UserComment = $UserComment;

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

    public function getComment(): ?self
    {
        return $this->Comment;
    }

    public function setComment(?self $Comment): static
    {
        $this->Comment = $Comment;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(self $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setComment($this);
        }

        return $this;
    }

    public function removeComment(self $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getComment() === $this) {
                $comment->setComment(null);
            }
        }

        return $this;
    }
}
