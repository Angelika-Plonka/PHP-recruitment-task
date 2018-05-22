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

    /** @var array */
    public $msg;

    /** @var IdentificationNumberValidator */
    protected $validatedIdentificationNumber;

    public function __construct(EntityManagerInterface $entityManager, IdentificationNumberValidator $validatedIdentificationNumber, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->validatedIdentificationNumber = $validatedIdentificationNumber;
        $this->userRepository = $this->entityManager->getRepository(User::class);
    }

    /**
     * add a new user to database
     * @param $request
     * @return mixed
     */
    public function handleUser($request)
    {
        $firstname = $request->firstname;
        $surname = $request->surname;
        $country_code = $request->country_code;
        $identification_number = $request->identification_number;

        if ($country_code === "DE") {
            if ($this->validatedIdentificationNumber->validateIdentifikationsnummerl($identification_number) === true) {
                $user = new User();
                $user->setFirstname($firstname);
                $user->setSurname($surname);
                $user->setCountryCode($country_code);
                $user->setIdentificationNumber($identification_number);
                $user->setUserApplicationId(mt_rand(800000000, 899999999));

                $this->entityManager->persist($user);
                $this->entityManager->flush();
                return $user;
            } else {
                $this->msg = ["identificationNumber", "Invalid value for identificationNumber."];
            }

        } elseif ($country_code === "PL") {
            if ($this->validatedIdentificationNumber->validatePesel($identification_number) === true) {
                $user = new User();
                $user->setFirstname($firstname);
                $user->setSurname($surname);
                $user->setCountryCode($country_code);
                $user->setIdentificationNumber($identification_number);
                $user->setUserApplicationId(mt_rand(800000000, 899999999));

                $this->entityManager->persist($user);
                $this->entityManager->flush();
                return $user;
            } else {
                $this->msg = ["identificationNumber", "Invalid value for identificationNumber."];
            }
        } else {
            $this->msg = ["country", "Invalid value for country"];
        }
    }
}