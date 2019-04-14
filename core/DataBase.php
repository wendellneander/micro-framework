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

    /**
     * @var $currentConfig array
     */
    private $currentConfig;

    /**
     * @var $configKeys array
     */
    private $configKeys;

    /**
     * @var Capsule $capsule
     */
    protected $capsule;

    /**
     * @var integer $port
     */
    private $port;

    /**
     * @return DataBase
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;

            static::$instance->setConfigKeys();
        }

        return static::$instance;
    }

    /**
     * @throws \Exception
     */
    public static function beginTransaction()
    {
        self::$instance->capsule->getConnection()->beginTransaction();
    }

    public static function commit()
    {
        self::$instance->capsule->getConnection()->commit();
    }

    /**
     * @throws \Exception
     */
    public static function rollBack()
    {
        self::$instance->capsule->getConnection()->rollBack();
    }

    public function run()
    {
        $this->eloquent();
    }

    /**
     * @param string $key
     * @param array $config
     * @return $this
     */
    public function addConfig(string $key, array $config)
    {
        $this->config[$key] = $config;

        return $this;
    }

    /**
     * @param string $key
     * @return $this
     */
    public function setCurrentConfig(string $key)
    {
        $this->currentConfig = isset($this->config[$key]) ? $this->config[$key] : [];

        foreach ($this->currentConfig as $key => $value) {
            if (!in_array($key, $this->configKeys)){
                continue;
            }

            $this->$key = $value;
        }

        return $this;
    }

    private function setConfigKeys()
    {
        $this->configKeys = [
            'driver',
            'host',
            'database',
            'username',
            'password',
            'charset',
            'collation',
            'prefix',
            'port'
        ];
    }

    /**
     * Start eloquent ORM
     */
    private function eloquent()
    {
        $this->capsule = new Capsule;

        $this->capsule->addConnection([
            'driver' => $this->driver,
            'host' => $this->host,
            'database' => $this->database,
            'username' => $this->username,
            'password' => $this->password,
            'charset' => $this->charset,
            'collation' => $this->collation,
            'port' => $this->port,
            'prefix' => ''
        ]);

        $this->capsule->bootEloquent();
    }
}
