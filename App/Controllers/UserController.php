<?php

namespace App\Controllers;

use App\Models\User;

class UserController
{
    public function post()
    {
        return User::insert($_POST);
    }

    public function get(string $email, string $password)
    {
        return User::login($email, $password);
    }

    public function delete()
    {
        $_DELETE = json_decode(file_get_contents('php://input'), true);
        return User::delete($_DELETE);
    }

    public function put()
    {
        $_PUT = json_decode(file_get_contents('php://input'), true); /* php://input -> requisições */
        return User::update($_PUT);
    }
}
