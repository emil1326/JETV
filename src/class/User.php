<?php

class User
{
    private int $id;
    private string $username;
    private string $firstName;
    private string $lastName;
    private string $password;
    private int $caps;
    private int $dexterity;
    private int $health;
    private int $maxWeight;
    private bool $isAdmin;
    private string $profileImage;

    public function __construct(
        int $id,
        string $username,
        string $firstName,
        string $lastName,
        string $password,
        int $caps,
        int $dexterity,
        int $health,
        int $maxWeight,
        bool $isAdmin,
        string $profileImage,
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->password = $password;
        $this->caps = $caps;
        $this->dexterity = $dexterity;
        $this->health = $health;
        $this->maxWeight = $maxWeight;
        $this->isAdmin = $isAdmin;
        $this->profileImage = $profileImage;
    }

    // GETTERS //
    public function getId(): int
    {
        return $this->id;
    }
    public function getUsername(): string
    {
        return $this->username;
    }
    public function getFirstName(): string
    {
        return $this->firstName;
    }
    public function getLastName(): string
    {
        return $this->lastName;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function getCaps(): int
    {
        return $this->caps;
    }
    public function getDexterity(): int
    {
        return $this->dexterity;
    }
    public function getHealth(): int
    {
        return $this->health;
    }
    public function getMaxWeight(): int
    {
        return $this->maxWeight;
    }
    public function getIsAdmin(): bool
    {
        return $this->isAdmin;
    }
    public function getProfileImage(): string
    {
        return $this->profileImage;
    }

    // SETTERS //
    public function setUsername(string $username)
    {
        $this->username = $username;
    }
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }
    public function setPassword(string $password)
    {
        $this->password = $password;
    }
    public function setCaps(string $caps)
    {
        $this->caps = (int)$caps;
    }
    public function setDexterity(string $dexterity)
    {
        $this->dexterity = (int)$dexterity;
    }
    public function setHealth(string $health)
    {
        $this->health = (int)$health;
    }
    public function setMaxWeight(string $maxWeight)
    {
        $this->maxWeight = (int)$maxWeight;
    }
    // cannot set is admin
    public function setProfileImage(string $profileImage)
    {
        $this->profileImage = $profileImage;
    }
}
