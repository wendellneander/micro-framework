<?php
/**
 * Created by PhpStorm.
 * User: Wendell
 * Date: 08/04/2019
 * Time: 23:50
 */

namespace Core;


class Session
{
    /**
     * @var self $instance
     */
    private static $instance;

    /**
     * @return Session
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    public static function flash($key, $value)
    {
        $_SESSION['flash'][$key]['value'] = $value;
        $_SESSION['flash'][$key]['times'] = 0;
    }

    public static function getFlash($key)
    {
        if (!isset($_SESSION['flash'])) {
            return null;
        }

        if (!isset($_SESSION['flash'][$key])) {
            return null;
        }

        return $_SESSION['flash'][$key]['value'];
    }

    public function clearFlashes()
    {
        if (!isset($_SESSION['flash'])) {
            return null;
        }

        foreach ($_SESSION['flash'] as $key => $flash) {
            if ($flash['times'] < 1) {

                $_SESSION['flash'][$key]['times'] += 1;

                continue;
            }

            unset($_SESSION['flash'][$key]);
        }
    }

}
