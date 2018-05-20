<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UsersController extends Controller
{

    public function listAction()
    {
        return $this->render('users/list.html.twig');
    }

}