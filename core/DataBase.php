<?php
/**
 * Created by PhpStorm.
 * User: Wendell
 * Date: 09/04/2019
 * Time: 01:56
 */

namespace Core;

use PDO;

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
     * @var $user string
     */
    private $user;

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
     * @var $pdo PDO
     */
    private $pdo;

    const MYSQL_DRIVER = 'mysql';
    const SQLITE_DRIVER = 'sqlite';

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;

            static::$instance->run();
        }

        return static::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }

    private function run()
    {
        $this->getConfig();

        $this->connect();
    }

    private function getConfig()
    {
        $this->config = include_once __DIR__ . '/../config/database.php';

        $this->driver = $this->config['driver'];

        $this->host = isset($this->config[$this->driver]['host']) ? $this->config[$this->driver]['host'] : null;

        $this->database = isset($this->config[$this->driver]['database']) ? $this->config[$this->driver]['database'] : null;

        $this->user = isset($this->config[$this->driver]['user']) ? : null;

        $this->password = isset($this->config[$this->driver]['password']) ? $this->config[$this->driver]['password'] : null;

        $this->charset = isset($this->config[$this->driver]['charset']) ? $this->config[$this->driver]['charset'] : null;

        $this->collation = isset($this->config[$this->driver]['collation']) ? $this->config[$this->driver]['collation'] : null;
    }

    private function connect()
    {
        if($this->pdo){
            $status = $this->pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS);

            if($status){
                return;
            }
        }

        if(!$this->host){
            return;
        }

        switch ($this->driver) {
            case self::MYSQL_DRIVER :

                $this->mysql();

                break;
            case self::SQLITE_DRIVER :

                $this->sqlite();

                break;
        }
    }

    private function mysql()
    {
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->database;charset=$this->charset", $this->user, $this->password);

            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

            $this->pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES '$this->charset' COLLATE '$this->collation'");
        } catch (\PDOException $exception) {
            exit($exception->getMessage());
        }
    }

    private function sqlite()
    {
        $sqlite = __DIR__ . '/../database/' . $this->config['sqlite']['host'];
        $sqlite .= "sqlite:" . $sqlite;

        try {
            $this->pdo = new PDO($sqlite);

            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

        } catch (\PDOException $exception) {
            exit($exception->getMessage());
        }
    }

}
