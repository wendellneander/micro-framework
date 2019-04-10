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
    private $viewPath;
    private $viewData;
    private $blade;

    protected function view($path, $data = null)
    {
        $this->viewPath = $path;

        $this->viewData = $data;

        $this->blade = Container::blade();

        $viewRendered = $this->blade->render($this->viewPath, $this->viewData);

        echo $viewRendered;
    }
}
