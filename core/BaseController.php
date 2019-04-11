<?php
/**
 * Created by PhpStorm.
 * User: Wendell
 * Date: 09/04/2019
 * Time: 01:25
 */

namespace Core;

abstract class BaseController
{
    protected function view(string $path, array $params = [])
    {
        Blade::getInstance()->view($path, $params);
    }
}
