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

    public function getDataBase()
    {
        $conf = include_once __DIR__ . '/../config/database.php';

        if ($conf['driver'] == 'sqlite') {
            $sqlite = __DIR__ . '/../database/' . $conf['sqlite']['host'];
            $sqlite .= "sqlite:" . $sqlite;

            try {
                $pdo = new PDO($sqlite);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                return $pdo;
            } catch (\PDOException $exception) {
                exit($exception->getMessage());
            }
        } else if ($conf['driver'] == 'mysql') {
            $host = $conf['mysql']['host'];
            $database = $conf['mysql']['database'];
            $user = $conf['mysql']['user'];
            $password = $conf['mysql']['password'];
            $charset = $conf['mysql']['charset'];
            $collation = $conf['mysql']['collation'];

            try {
                $pdo = new PDO("mysql:host=$host;dbname=$database;charset=$charset", $user, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                $pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES '$charset' COLLATE '$collation'");
                return $pdo;
            } catch (\PDOException $exception) {
                exit($exception->getMessage());
            }
        }
    }

}
