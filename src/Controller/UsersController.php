<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Service\UserProvider;

class UsersController extends Controller
{
    /**
     * Matches / exactly
     *
     * @Route("/users", methods="GET")
     */
    public function listAction()
    {
        return $this->render('users/list.html.twig');
    }


    /**
     * Add a new user into database
     * *Example request:*
     * ```
     * {
     *      "firstname": "Ania",
     *      "surname": "Kowalska",
     *      "country_code": "PL",
     *      "identification_number": "55042989169"
     * }
     * ```
     *
     * POST /api/v1/users
     * Content-Type: application/json
     *
     * Matches /api/v1/users exactly
     *
     * @Route("/api/v1/users", methods="POST")
     * @return Response
     */
    public function createUserAction(Request $request, UserProvider $userProvider): Response
    {
        $emptyFields = $this->validateQueryParams(json_decode($request->getContent()), ['firstname', 'surname', 'country_code', 'identification_number']);
        if (count($emptyFields) > 0) {
            return $this->json(
                [
                    'code' => '400',
                    'message' => 'Validation Failed',
                    'errors' => [
                        "This value should not be blank." => $emptyFields
                    ]
                ],
                400
            );
        } elseif (count($emptyFields) === 0) {
            $typeOfReturn = $userProvider->handleUser(json_decode($request->getContent()));

            if ($typeOfReturn instanceof User) {
                return $this->json(
                    [
                        'code' => '201',
                        'message' => 'Your account has been successfully created',
                        'userId' => $typeOfReturn->getUserApplicationId()
                    ],
                    201,
                    [
                        'Location' => '/api/v1/user/' . $typeOfReturn->getUserApplicationId()
                    ]
                );
            } else {
                return $this->json(
                    [
                        'code' => '422',
                        'message' => 'Validation Failed',
                        'errors' => [
                            $typeOfReturn[0] => $typeOfReturn[1]
                        ]
                    ],
                    422
                );
            }
        }
    }

    /**
     * @param $request
     * @param array $params
     * @return array
     */
    private function validateQueryParams($request, array $params)
    {
        $errorFields = [];
        foreach ($params as $param) {
            $queryVal = $request->$param;
            if (empty($queryVal)) {
                $errorFields[] = $param;
            }
        }
        return $errorFields;
    }


}