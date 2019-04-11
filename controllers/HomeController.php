<?php
/**
 * Created by PhpStorm.
 * User: Wendell
 * Date: 08/04/2019
 * Time: 23:22
 */

namespace Controllers;

use Core\BaseController;
use Core\Request;

class HomeController extends BaseController
{
    public function index(Request $request)
    {
        $this->view('home/index', [
            'name' => 'Wendell',
            'age' => 20
        ]);
    }

}
