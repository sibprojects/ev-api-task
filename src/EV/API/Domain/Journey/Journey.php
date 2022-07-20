<?php

namespace EV\API\Domain\Journey;

use Doctrine\ORM\Mapping as ORM;
use EV\API\Application\Service\JourneyRideService;
use EV\API\Domain\Car\Car;
use EV\API\Infrastructure\Repository\JourneyRepository;

#[ORM\Entity(repositoryClass: JourneyRepository::class)]
class Journey
{
    #[ORM\Id]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $people = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'journeys')]
    private ?Car $car = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getPeople(): ?int
    {
        return $this->people;
    }

    public function setPeople(int $people): self
    {
        $this->people = $people;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): self
    {
        $this->car = $car;

        return $this;
    }
}
