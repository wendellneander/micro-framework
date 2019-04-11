<?php
/**
 * Created by PhpStorm.
 * User: devmaker
 * Date: 2019-04-10
 * Time: 18:37
 */

namespace Core;


class Application extends Container
{
    /**
     * @var \Jenssegers\Blade\Blade $engine
     */
    private $templateEngine;

    public function __construct()
    {
        $this->startTemplateEngine();
    }

    private function startTemplateEngine()
    {
        $viewPath = __DIR__ . '/../views';

        $cachePath = __DIR__ . '/../storage/cache/views';

        $this->templateEngine = new \Jenssegers\Blade\Blade([$viewPath], $cachePath);
    }

    protected function startDataBase()
    {

    }

    protected function view($path, $data = null)
    {
        $view = $this->templateEngine->render($path, $data);

        echo $view;
    }

    public static function pageNotFound()
    {
        exit('Page not found');
    }
}
