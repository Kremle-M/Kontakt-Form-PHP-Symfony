<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduktRepository;

#[ORM\Entity(repositoryClass: ProduktRepository::class)]
#[ORM\Table(name: 'produkt')]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', unique: true)]
    private string $externalId;

    #[ORM\Column(type: 'string', length: 255)]
    private string $nazev;

    #[ORM\Column(type: 'float')]
    private float $cenaCZK;

    #[ORM\Column(type: 'integer')]
    private int $skladem;

    #[ORM\Column(type: 'string', length: 255)]
    private string $znacka;

    #[ORM\Column(name: 'katalog_cislo', type: 'string', length: 255, nullable: true)]
    private ?string $katalog_cislo = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $vytvoreni;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $aktualizace;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExternalId(): string
    {
        return $this->externalId;
    }
    public function setExternalId(string $externalId): self
    {
        $this->externalId = $externalId;
        return $this;
    }
    public function getNazev(): string
    {
        return $this->nazev;
    }
    public function setNazev(string $nazev): self
    {
        $this->nazev = $nazev;
        return $this;
    }
    public function getCenaCZK(): float
    {
        return $this->cenaCZK;
    }
    public function setCenaCZK(float $cenaCZK): self
    {
        $this->cenaCZK = $cenaCZK;
        return $this;
    }
    public function getSkladem(): int
    {
        return $this->skladem;
    }

    public function setSkladem(int $skladem): self
    {
        $this->skladem = $skladem;
        return $this;
    }
    public function getZnacka(): string
    {
        return $this->znacka;
    }
    public function setZnacka(string $znacka): self
    {
        $this->znacka = $znacka;
        return $this;
    }
    public function getKatalogCislo(): ?string
    {
        return $this->katalog_cislo;
    }
    public function setKatalogCislo(?string $katalog_cislo): self
    {
        $this->katalog_cislo = $katalog_cislo;
        return $this;
    }
    public function getVytvoreni(): \DateTimeImmutable
    {
        return $this->vytvoreni;
    }
    public function setVytvoreni(\DateTimeImmutable $vytvoreni): self
    {
        $this->vytvoreni = $vytvoreni;
        return $this;
    }
    public function getAktualizace(): \DateTime
    {
        return $this->aktualizace;
    }

    public function setAktualizace(\DateTime $aktualizace): self
    {
        $this->aktualizace = $aktualizace;
        return $this;
    }
}