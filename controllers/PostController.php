<?php
/**
 * Created by PhpStorm.
 * User: Wendell
 * Date: 08/04/2019
 * Time: 23:39
 */

namespace Controllers;

use Core\BaseController;
use Core\Request;

class PostController extends BaseController
{
    public function index()
    {
        echo "Posts ";
    }

    public function show(Request $request, $id)
    {
        print_r($request->all());

        echo "Post ".$id;
    }
}
