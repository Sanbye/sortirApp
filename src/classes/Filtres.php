<?php

namespace App\classes;

use App\Repository\FiltresRepository;
use App\Entity\Campus;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FiltresRepository::class)]
class Filtres
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Campus $campus = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $search = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $dateStart = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Assert\GreaterThanOrEqual(propertyPath: 'dateStart')]
    private ?DateTimeInterface $dateEnd = null;

    #[ORM\Column(nullable: true)]
    private ?bool $choiceOrganisateur = false;
    #[ORM\Column(nullable: true)]
    private ?bool $choiceInscrit = false;
    #[ORM\Column(nullable: true)]
    private ?bool $choiceNoInscrit = false;
    #[ORM\Column(nullable: true)]
    private ?bool $choiceEnd = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): self
    {
        $this->campus = $campus;

        return $this;
    }

    public function getSearch(): ?string
    {
        return $this->search;
    }

    public function setSearch(?string $search): self
    {
        $this->search = $search;

        return $this;
    }

    public function getDateStart(): ?DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(DateTimeInterface $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getChoiceOrganisateur(): ?bool
    {
        return $this->choiceOrganisateur;
    }

    public function setChoiceOrganisateur(bool $choiceOrganisateur): self
    {
        $this->choiceOrganisateur = $choiceOrganisateur;

        return $this;
    }

    public function getChoiceInscrit(): ?bool
    {
        return $this->choiceInscrit;
    }

    public function setChoiceInscrit(bool $choiceInscrit): self
    {
        $this->choiceInscrit = $choiceInscrit;

        return $this;
    }

    public function getChoiceNoInscrit(): ?bool
    {
        return $this->choiceNoInscrit;
    }

    public function setChoiceNoInscrit(bool $choiceNoInscrit): self
    {
        $this->choiceNoInscrit = $choiceNoInscrit;

        return $this;
    }

    public function getChoiceEnd(): ?bool
    {
        return $this->choiceEnd;
    }

    public function setChoiceEnd(bool $choiceEnd): self
    {
        $this->choiceEnd = $choiceEnd;

        return $this;
    }
}
