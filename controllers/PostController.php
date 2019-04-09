<?php
/**
 * Created by PhpStorm.
 * User: Wendell
 * Date: 08/04/2019
 * Time: 23:39
 */

namespace Controllers;


class PostController
{
    public function index()
    {
        echo "Posts ";
    }

    public function show($id)
    {
        echo "Post ".$id;
    }
}
