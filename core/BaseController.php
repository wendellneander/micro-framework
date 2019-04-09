<?php
/**
 * Created by PhpStorm.
 * User: Wendell
 * Date: 09/04/2019
 * Time: 01:25
 */

namespace Core;

abstract class BaseController
{
    protected $view;
    private $viewPath;
    private $templatePath;

    public function __construct()
    {
        $this->view = new \stdClass();
    }

    protected function view($viewPath, $templatePath = null)
    {
        $this->viewPath = $viewPath;

        $this->templatePath = $templatePath;

        if ($templatePath) {
            $this->template();
        }else{
            $this->content();
        }

    }

    protected function content()
    {
        if (file_exists(__DIR__ . "/../views/{$this->viewPath}.php")) {
            require_once __DIR__ . "/../views/{$this->viewPath}.php";
        } else {
            exit('View not found');
        }
    }

    protected function template()
    {
        if (file_exists(__DIR__ . "/../views/{$this->templatePath}.php")) {
            require_once __DIR__ . "/../views/{$this->templatePath}.php";
        } else {
            exit('View not found');
        }
    }
}
