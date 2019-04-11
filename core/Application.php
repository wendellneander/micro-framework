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
     * @var Router $router
     */
    private $router;

    /**
     * @var DataBase $database
     */
    private $database;

    /**
     * @var \Jenssegers\Blade\Blade $templateEngine
     */
    private $templateEngine;

    /**
     * @param $path
     * @param null $data
     */
    protected function view($path, $data = null)
    {
        $view = $this->templateEngine->render($path, $data);

        echo $view;
    }

    /**
     * @return Router
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * @param Router $router
     */
    public function setRouter($router)
    {
        $this->router = $router;
    }

    /**
     * @return DataBase
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * @param DataBase $database
     */
    public function setDatabase($database)
    {
        $this->database = $database;
    }

    /**
     * @return \Jenssegers\Blade\Blade
     */
    public function getTemplateEngine()
    {
        return $this->templateEngine;
    }

    /**
     * @param \Jenssegers\Blade\Blade $templateEngine
     */
    public function setTemplateEngine($templateEngine)
    {
        $this->templateEngine = $templateEngine;
    }
}
