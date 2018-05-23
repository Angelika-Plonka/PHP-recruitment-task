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

    public function __construct(EntityManagerInterface $entityManager, IdentificationNumberValidator $validatedIdentificationNumber)
    {
        $this->entityManager = $entityManager;
        $this->validatedIdentificationNumber = $validatedIdentificationNumber;
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
        $user->setUserApplicationId($userApplicationId);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user;
    }

    /**
     * add a new user to database
     * @param $request
     * @return mixed
     */
    public function handleUser($request)
    {
        $dataFromUser = [
            'firstname' => $request->firstname,
            'surname' => $request->surname,
            'country_code' => $request->country_code,
            'identification_number' => $request->identification_number
        ];

//        if(empty($dataFromUser['firstname']) || empty($dataFromUser['surname']) || empty($dataFromUser['country_code']) || empty($dataFromUser['identification_number'])){
//            foreach ($dataFromUser as $key => $val){
//                if(empty($val)){
////                $this->msg[] = [$key, "This value should not be blank."];
//                $this->msg[$key] = ["This value should not be blank."];
//                }
//                return false;
//            }
//        }

        $errorMsg = [];

        if ($dataFromUser['country_code'] === "DE") {
            if ($this->validatedIdentificationNumber->identifikationsNummer($dataFromUser['identification_number']) === true) {
                return $this->saveUserIntoDatabase(
                    $dataFromUser['firstname'],
                    $dataFromUser['surname'],
                    $dataFromUser['country_code'],
                    $dataFromUser['identification_number']
                );

            } else {
                return $errorMsg = ["identificationNumber", "Invalid value for identificationNumber."];
            }

        } elseif ($dataFromUser['country_code'] === "PL") {
            if ($this->validatedIdentificationNumber->Pesel($dataFromUser['identification_number']) === true) {
                return $this->saveUserIntoDatabase(
                    $dataFromUser['firstname'],
                    $dataFromUser['surname'],
                    $dataFromUser['country_code'],
                    $dataFromUser['identification_number']
                );

            } else {
                return $errorMsg = ["identificationNumber", "Invalid value for identificationNumber."];
            }
        } else {
            return $errorMsg[] = ["country", "Invalid value for country"];
        }
    }
}