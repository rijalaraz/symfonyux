<?php

namespace App\Entity;

use App\Repository\EtablissementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtablissementRepository::class)]
class Etablissement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nombre_place = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tarif_min = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tarif_max = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_etablissement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombrePlace(): ?int
    {
        return $this->nombre_place;
    }

    public function setNombrePlace(int $nombre_place): static
    {
        $this->nombre_place = $nombre_place;

        return $this;
    }

    public function getTarifMin(): ?string
    {
        return $this->tarif_min;
    }

    public function setTarifMin(?string $tarif_min): static
    {
        $this->tarif_min = $tarif_min;

        return $this;
    }

    public function getTarifMax(): ?string
    {
        return $this->tarif_max;
    }

    public function setTarifMax(?string $tarif_max): static
    {
        $this->tarif_max = $tarif_max;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getNomEtablissement(): ?string
    {
        return $this->nom_etablissement;
    }

    public function setNomEtablissement(string $nom_etablissement): static
    {
        $this->nom_etablissement = $nom_etablissement;

        return $this;
    }
}
