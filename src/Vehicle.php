<?php

class Vehicle
{
    private int $id;
    private string $brand;
    private string $model;
    private string $fuel;
    private string $gearShift;
    private string $plate;
    private string $observedDamages;
    private string $description;
    private int $km;
    private int $buyPrice;
    private int $sellPrice;
    private int $iva;
    private bool $isNew;
    private bool $includedTransport;
    private string $numChassis;
    private string $color;
    private DateTime $registrationDate;
    private string $provider;
    private Image $image;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    public function getFuel(): string
    {
        return $this->fuel;
    }

    public function setFuel(string $fuel): void
    {
        $this->fuel = $fuel;
    }

    public function getGearShift(): string
    {
        return $this->gearShift;
    }

    public function setGearShift(string $gearShift): void
    {
        $this->gearShift = $gearShift;
    }

    public function getPlate(): string
    {
        return $this->plate;
    }

    public function setPlate(string $plate): void
    {
        $this->plate = $plate;
    }

    public function getObservedDamages(): string
    {
        return $this->observedDamages;
    }

    public function setObservedDamages(string $observedDamages): void
    {
        $this->observedDamages = $observedDamages;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getKm(): int
    {
        return $this->km;
    }

    public function setKm(int $km): void
    {
        $this->km = $km;
    }

    public function getBuyPrice(): int
    {
        return $this->buyPrice;
    }

    public function setBuyPrice(int $buyPrice): void
    {
        $this->buyPrice = $buyPrice;
    }

    public function getSellPrice(): int
    {
        return $this->sellPrice;
    }

    public function setSellPrice(int $sellPrice): void
    {
        $this->sellPrice = $sellPrice;
    }

    public function getIva(): int
    {
        return $this->iva;
    }

    public function setIva(int $iva): void
    {
        $this->iva = $iva;
    }

    public function isNew(): bool
    {
        return $this->isNew;
    }

    public function setIsNew(bool $isNew): void
    {
        $this->isNew = $isNew;
    }

    public function isIncludedTransport(): bool
    {
        return $this->includedTransport;
    }

    public function setIncludedTransport(bool $includedTransport): void
    {
        $this->includedTransport = $includedTransport;
    }

    public function getNumChassis(): string
    {
        return $this->numChassis;
    }

    public function setNumChassis(string $numChassis): void
    {
        $this->numChassis = $numChassis;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    public function getRegistrationDate(): DateTime
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(DateTime $registrationDate): void
    {
        $this->registrationDate = $registrationDate;
    }

    public function getProvider(): string
    {
        return $this->provider;
    }

    public function setProvider(string $provider): void
    {
        $this->provider = $provider;
    }

    public function getImage(): Image
    {
        return $this->image;
    }

    public function setImage(Image $image): void
    {
        $this->image = $image;
    }
}