<?php

namespace EV\API\Domain\Car;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use EV\API\Domain\Journey\Journey;
use EV\API\Infrastructure\Repository\CarRepository;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $seats = null;

    #[ORM\OneToMany(mappedBy: 'car', targetEntity: Journey::class)]
    private Collection $journeys;

    public function __construct()
    {
        $this->journeys = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getSeats(): ?int
    {
        return $this->seats;
    }

    public function setSeats(int $seats): self
    {
        $this->seats = $seats;

        return $this;
    }

    /**
     * @return Collection<int, Journey>
     */
    public function getJourneys(): Collection
    {
        return $this->journeys;
    }

    public function addJourney(Journey $journey): self
    {
        if (!$this->journeys->contains($journey)) {
            $this->journeys[] = $journey;
            $journey->setCar($this);
        }

        return $this;
    }

    public function removeJourney(Journey $journey): self
    {
        if ($this->journeys->removeElement($journey)) {
            // set the owning side to null (unless already changed)
            if ($journey->getCar() === $this) {
                $journey->setCar(null);
            }
        }

        return $this;
    }
}
