<?php

declare(strict_types=1);

namespace App\Controller;

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

            $user = $userProvider->handleUser(json_decode($request->getContent()));

            if (!$user) {
                return $this->json(
                    [
                        'code' => '422',
                        'message' => 'Validation Failed',
                        'errors' => [
                            $userProvider->msg[0] => $userProvider->msg[1]
                        ]
                    ],
                    422
                );
            } else {
                return $this->json(
                    [
                        'userId' => $user->getUserApplicationId()
                    ],
                    201
                );
            }

        } catch (\Exception $e) {
            return new Response($e->getMessage(), 422);
        }
    }

}