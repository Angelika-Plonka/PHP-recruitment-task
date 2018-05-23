<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use PhpParser\Node\Expr\Array_;
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
     * Matches /api/v1/users exactly
     *
     * @Route("/api/v1/users", methods="POST")
     * @return Response
     */
    public function createUserAction(Request $request, UserProvider $userProvider): Response
    {
        try {
            $typeOfReturn = $userProvider->handleUser(json_decode($request->getContent()));


            $emptyFields = $this->validateQueryParams($request, ['firstname', 'surname', 'country_code', 'identification_number']);
            if (count($emptyFields) > 0) {
                return $this->json(
                    [
                        'code' => '422',
                        'message' => 'Validation Failed',
                        'errors' => [
                            "This value should not be blank." => $emptyFields
                        ]
                    ],
                    422
                );
            } else {

                if ($typeOfReturn instanceof User) {
                    return $this->json(
                        [
                            'userId' => $typeOfReturn->getUserApplicationId()
                        ],
                        201
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


        } catch (\Exception $e) {
            return new Response($e->getMessage(), 500);
        }
    }

    /**
     * @param Request $request
     * @param array $params
     *
     * @return array
     */
    private function validateQueryParams(Request $request, array $params)
    {
        $errorFields = [];
        foreach ($params as $param) {
            $queryVal = $request->query->get($param);
            if ($queryVal === null) {
                $errorFields[] = $param;
            }
        }

        return $errorFields;
    }


}