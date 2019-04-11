<?php
/**
 * Created by PhpStorm.
 * User: Wendell
 * Date: 08/04/2019
 * Time: 23:22
 */

namespace Controllers;

use Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $this->view('home/index');
    }

}
