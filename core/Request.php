<?php
/**
 * Created by PhpStorm.
 * User: Wendell
 * Date: 08/04/2019
 * Time: 23:50
 */

namespace Core;


class Request
{
    /**
     * @var $instance self
     */
    private static $instance;

    /**
     * @var $get array
     */
    private $get;

    /**
     * @var $post array
     */
    private $post;

    /**
     * @var $all array
     */
    private $all;

    /**
     * @return Request
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
        $this->get = $_GET;

        $this->post = $_POST;

        $this->all = array_merge($_GET, $_POST);
    }

    /**
     * @return array
     */
    public function get()
    {
        return $this->get;
    }

    /**
     * @return array
     */
    public function post()
    {
        return $this->post;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->all;
    }

}
