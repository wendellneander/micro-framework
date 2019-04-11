<?php
/**
 * Created by PhpStorm.
 * User: Wendell
 * Date: 09/04/2019
 * Time: 01:56
 */

namespace Core;

use Illuminate\Database\Capsule\Manager as Capsule;

class DataBase
{
    /**
     * @var $instance self
     */
    private static $instance;

    /**
     * @var $config array
     */
    private $config;

    /**
     * @var $driver string
     */
    private $driver;

    /**
     * @var $host string
     */
    private $host;

    /**
     * @var $username string
     */
    private $username;

    /**
     * @var $$password string
     */
    private $password;

    /**
     * @var $database string
     */
    private $database;

    /**
     * @var $charset string
     */
    private $charset;

    /**
     * @var $collation string
     */
    private $collation;

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;

            static::$instance->run();
        }

        return static::$instance;
    }

    private function run()
    {
        $this->getConfig();

        $this->eloquent();
    }

    private function eloquent() {
        $capsule = new Capsule;

        $capsule->addConnection([
            'driver'    => $this->driver,
            'host'      => $this->host,
            'database'  => $this->database,
            'username'  => $this->username,
            'password'  => $this->password,
            'charset'   => $this->charset,
            'collation' => $this->collation,
            'prefix'    => ''
        ]);

        $capsule->bootEloquent();
    }

    private function getConfig()
    {
        $this->config = include_once __DIR__ . '/../config/database.php';

        $this->driver = $this->config['driver'];

        $this->host = isset($this->config[$this->driver]['host']) ? $this->config[$this->driver]['host'] : null;
        $this->host = $this->host == 'localhost' ? '127.0.0.1' : $this->host;

        $this->database = isset($this->config[$this->driver]['database']) ? $this->config[$this->driver]['database'] : null;

        $this->username = isset($this->config[$this->driver]['username']) ? $this->config[$this->driver]['username'] : null;

        $this->password = isset($this->config[$this->driver]['password']) ? $this->config[$this->driver]['password'] : null;

        $this->charset = isset($this->config[$this->driver]['charset']) ? $this->config[$this->driver]['charset'] : null;

        $this->collation = isset($this->config[$this->driver]['collation']) ? $this->config[$this->driver]['collation'] : null;
    }
}
