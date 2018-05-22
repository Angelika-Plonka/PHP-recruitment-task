<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $country_code;

    /**
     * @ORM\Column(type="string", length=11)
     */
    private $identification_number;

    /**
     * @ORM\Column(type="integer")
     */
    private $user_application_id;

    public function getId()
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getCountryCode(): ?string
    {
        return $this->country_code;
    }

    public function setCountryCode(string $country_code): self
    {
        $this->country_code = $country_code;

        return $this;
    }

    public function getIdentificationNumber(): ?int
    {
        return $this->identification_number;
    }

    public function setIdentificationNumber(int $identification_number): self
    {
        $this->identification_number = $identification_number;

        return $this;
    }

    public function getUserApplicationId(): ?int
    {
        return $this->user_application_id;
    }

    public function setUserApplicationId(int $user_application_id): self
    {
        $this->user_application_id = $user_application_id;

        return $this;
    }
}