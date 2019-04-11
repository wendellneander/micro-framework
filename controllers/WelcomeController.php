<?php
/**
 * Created by PhpStorm.
 * User: Wendell
 * Date: 08/04/2019
 * Time: 23:22
 */

namespace Controllers;

use Core\Controller;
use Repository\GenericRepository;

class WelcomeController extends Controller
{
    public function __construct(GenericRepository $generic)
    {

    }

    public function index()
    {
        $this->view('welcome/index');
    }

}
