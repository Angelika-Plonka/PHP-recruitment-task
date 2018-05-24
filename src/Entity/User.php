<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("user_application_id")
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
     * @ORM\Column(name="firstname", type="string", length=30)
     */
    private $firstname;

    /**
     * @ORM\Column(name="surname", type="string", length=30)
     */
    private $surname;

    /**
     * @ORM\Column(name="country_code", type="string", length=2)
     */
    private $countryCode;

    /**
     * @ORM\Column(name="identification_number", type="string", length=11)
     */
    private $identificationNumber;

    /**
     * @var int $userApplicationId
     * @ORM\Column(name="user_application_id", type="integer", unique=true)
     */
    protected $userApplicationId;


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
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function getIdentificationNumber(): ?int
    {
        return $this->identificationNumber;
    }

    public function setIdentificationNumber(int $identificationNumber): self
    {
        $this->identificationNumber = $identificationNumber;

        return $this;
    }

    public function getUserApplicationId(): ?int
    {
        return $this->userApplicationId;
    }

    public function setUserApplicationId(int $userApplicationId): self
    {
        $this->userApplicationId = $userApplicationId;

        return $this;
    }
}
