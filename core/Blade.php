<?php
/**
 * Created by PhpStorm.
 * User: devmaker
 * Date: 2019-04-10
 * Time: 16:14
 */

namespace Core;

class Blade
{
    private $engine;
    private $viewPath;
    private $viewData;

    public function __construct()
    {
        $viewPath = __DIR__ . '/../views';

        $cachePath = __DIR__ . '/../storage/cache/views';

        $this->engine = new \Jenssegers\Blade\Blade([$viewPath], $cachePath);
    }

    public function view($path, $data = null)
    {
        $this->viewPath = $path;

        $this->viewData = $data;

        $viewRendered = $this->engine->render($this->viewPath, $this->viewData);

        echo $viewRendered;
    }
}
