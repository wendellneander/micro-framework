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
    private $get;
    private $post;
    private $all;

    public function __construct()
    {
        $this->get = new \stdClass();
        $this->post = new \stdClass();
        $this->all = new \stdClass();

        foreach ($_GET as $key => $value){
            $this->get->$key = $value;
            $this->all->$key = $value;
        }

        foreach ($_POST as $key => $value){
            $this->post->$key = $value;
            $this->all->$key = $value;
        }
    }

    /**
     * @return \stdClass
     */
    public function get()
    {
        return $this->get;
    }

    /**
     * @return \stdClass
     */
    public function post()
    {
        return $this->post;
    }

    /**
     * @return \stdClass
     */
    public function all()
    {
        return $this->all;
    }


}
