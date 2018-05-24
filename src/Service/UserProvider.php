<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use App\Entity\User;

class UserProvider
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var UserRepository */
    protected $userRepository;

    /** @var IdentificationNumberValidator */
    protected $validatedIdentificationNumber;

    public function __construct(EntityManagerInterface $entityManager, IdentificationNumberValidator $validatedIdentificationNumber, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->validatedIdentificationNumber = $validatedIdentificationNumber;
        $this->userRepository = $this->entityManager->getRepository(User::class);
    }

    /** Get a list of users in a database */
    public function findAllUsers()
    {
//        return $this->userRepository->getAll();
        return $this->userRepository->findAll();
    }

    /**
     * @param $firstname , $surname, $country_code, $identification_number
     * @return User
     */
    public function saveUserIntoDatabase($firstname, $surname, $country_code, $identification_number): User
    {
        $user = new User();
        $user->setFirstname($firstname);
        $user->setSurname($surname);
        $user->setCountryCode($country_code);
        $user->setIdentificationNumber($identification_number);
        $userApplicationId = mt_rand(100000000, 899999999);
        if ($this->userRepository->findOneByUserApplicationId($userApplicationId) == null) {
            $user->setUserApplicationId($userApplicationId);
        } else {
            $userApplicationId = mt_rand(100000000, 899999999);
            $user->setUserApplicationId($userApplicationId);
        }
        $user->setUserApplicationId($userApplicationId);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user;
    }

    /**
     * add a new user to database or display an error message in case of failure to add a user
     * @param $request
     * @return User | array
     */
    public function handleUser($request)
    {
        $firstname = $request->firstname;
        $surname = $request->surname;
        $country_code = $request->country_code;
        $identification_number = $request->identification_number;

        $errorMsg = [];

        if ($country_code === "DE") {
            if ($this->validatedIdentificationNumber->identifikationsNummer($identification_number) === true) {
                return $this->saveUserIntoDatabase(
                    $firstname,
                    $surname,
                    $country_code,
                    $identification_number
                );

            } else {
                return $errorMsg = ["identificationNumber", "Invalid value for identificationNumber."];
            }

        } elseif ($country_code === "PL") {
            if ($this->validatedIdentificationNumber->Pesel($identification_number) === true) {
                return $this->saveUserIntoDatabase(
                    $firstname,
                    $surname,
                    $country_code,
                    $identification_number
                );

            } else {
                return $errorMsg = ["identificationNumber", "Invalid value for identificationNumber."];
            }
        } else {
            return $errorMsg[] = ["country", "Invalid value for country"];
        }
    }
}