<?php
/**
 * Created by PhpStorm.
 * User: Wendell
 * Date: 08/04/2019
 * Time: 23:22
 */

namespace Controllers;

use Core\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        $this->view->name = 'Wendell Neander';

        $this->view('home/index', 'template');
    }

}
