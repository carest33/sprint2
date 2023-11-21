<?php

class Provider
{
    private int $id;
    private string $name;
    private string $completeAddress;
    private string $dni;
    private string $phone;
    private string $email;
    private string $CIF;
    private string $managerNIF;
    private string $bankTitle;
    private string $LOPDdoc;
    private string $constitutionArticle;
    private array $vehicles;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCompleteAddress(): string
    {
        return $this->completeAddress;
    }

    public function setCompleteAddress(string $completeAddress): void
    {
        $this->completeAddress = $completeAddress;
    }

    public function getDni(): string
    {
        return $this->dni;
    }

    public function setDni(string $dni): void
    {
        $this->dni = $dni;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getCIF(): string
    {
        return $this->CIF;
    }

    public function setCIF(string $CIF): void
    {
        $this->CIF = $CIF;
    }

    public function getManagerNIF(): string
    {
        return $this->managerNIF;
    }

    public function setManagerNIF(string $managerNIF): void
    {
        $this->managerNIF = $managerNIF;
    }

    public function getBankTitle(): string
    {
        return $this->bankTitle;
    }

    public function setBankTitle(string $bankTitle): void
    {
        $this->bankTitle = $bankTitle;
    }

    public function getLOPDdoc(): string
    {
        return $this->LOPDdoc;
    }

    public function setLOPDdoc(string $LOPDdoc): void
    {
        $this->LOPDdoc = $LOPDdoc;
    }

    public function getConstitutionArticle(): string
    {
        return $this->constitutionArticle;
    }

    public function setConstitutionArticle(string $constitutionArticle): void
    {
        $this->constitutionArticle = $constitutionArticle;
    }

    public function getVehicles(): array
    {
        return $this->vehicles;
    }

    public function setVehicles(array $vehicles): void
    {
        $this->vehicles = $vehicles;
    }
}