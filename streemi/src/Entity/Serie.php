<?php

namespace App\Entity;

use App\Repository\SerieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SerieRepository::class)]
class Serie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Media $Media = null;

    /**
     * @var Collection<int, Season>
     */
    #[ORM\OneToMany(targetEntity: Season::class, mappedBy: 'serie')]
    private Collection $Season;

    public function __construct()
    {
        $this->Season = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Season>
     */
    public function getSeason(): Collection
    {
        return $this->Season;
    }

    public function addSeason(Season $season): static
    {
        if (!$this->Season->contains($season)) {
            $this->Season->add($season);
            $season->setSerie($this);
        }

        return $this;
    }

    public function removeSeason(Season $season): static
    {
        if ($this->Season->removeElement($season)) {
            // set the owning side to null (unless already changed)
            if ($season->getSerie() === $this) {
                $season->setSerie(null);
            }
        }

        return $this;
    }
}
