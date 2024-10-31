<?php

namespace App\Entity;

use App\Repository\CastRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CastRepository::class)]
#[ORM\Table(name: '`cast`')]
class Cast
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Media>
     */
    #[ORM\ManyToMany(targetEntity: Media::class, inversedBy: 'casts')]
    private Collection $Casting;

    public function __construct()
    {
        $this->Casting = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Media>
     */
    public function getCasting(): Collection
    {
        return $this->Casting;
    }

    public function addCasting(Media $casting): static
    {
        if (!$this->Casting->contains($casting)) {
            $this->Casting->add($casting);
        }

        return $this;
    }

    public function removeCasting(Media $casting): static
    {
        $this->Casting->removeElement($casting);

        return $this;
    }
}
