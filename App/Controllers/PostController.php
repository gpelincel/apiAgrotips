<?php

namespace App\Controllers;

use App\Models\Post;

class PostController
{
    public function get(int $id_user = null)
    {
        if ($id_user) {
            return Post::selectProfile($id_user);
        } else {
            return Post::selectAll();
        }
    }

    public function post()
    {
        return Post::insert($_POST);
    }

    public function delete()
    {
        $_DELETE = json_decode(file_get_contents('php://input'), true);
        return Post::delete($_DELETE);
    }

    public function put()
    {
        $_PUT = json_decode(file_get_contents('php://input'), true); /* php://input -> requisições */
        return Post::update($_PUT);
    }
}
