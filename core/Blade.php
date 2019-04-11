<?php
/**
 * Created by PhpStorm.
 * User: devmaker
 * Date: 2019-04-11
 * Time: 13:43
 */

namespace Core;

class Blade
{
    /**
     * @var $instance self
     */
    private static $instance;
    /**
     * @var $engine \Jenssegers\Blade\Blade
     */
    private $engine;

    /**
     * @return Blade
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;

            static::$instance->start();
        }

        return static::$instance;
    }

    private function start()
    {
        $viewPath = __DIR__ . '/../views';

        $cachePath = __DIR__ . '/../storage/cache/views';

        $this->engine = new \Jenssegers\Blade\Blade([$viewPath], $cachePath);
    }

    /**
     * @param $path
     * @param null $data
     */
    public function view($path, $data = null)
    {
        $view = $this->engine->render($path, $data);

        echo $view;
    }
}
