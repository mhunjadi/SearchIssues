<?php

namespace App\Entity;

use App\Repository\IssueRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IssueRepository::class)]
class Issue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Word = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $PositiveResults = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $NegativeResults = null;

    #[ORM\Column]
    private ?float $Popularity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWord(): ?string
    {
        return $this->Word;
    }

    public function setWord(string $Word): static
    {
        $this->Word = $Word;

        return $this;
    }

    public function getPositiveResults(): ?string
    {
        return $this->PositiveResults;
    }

    public function setPositiveResults(string $PositiveResults): static
    {
        $this->PositiveResults = $PositiveResults;

        return $this;
    }

    public function getNegativeResults(): ?string
    {
        return $this->NegativeResults;
    }

    public function setNegativeResults(string $NegativeResults): static
    {
        $this->NegativeResults = $NegativeResults;

        return $this;
    }

    public function getPopularity(): ?float
    {
        return $this->Popularity;
    }

    public function setPopularity(float $Popularity): static
    {
        $this->Popularity = $Popularity;

        return $this;
    }
}
