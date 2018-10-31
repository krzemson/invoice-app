<?php
/**
 * Created by PhpStorm.
 * User: Jakub
 * Date: 30.10.2018
 * Time: 16:09
 */

function autoload($className)
{
    str_replace('\\', '/', $className);

    if (file_exists($className.'.php')) {
        require_once($className.'.php');
    }
}

spl_autoload_register('autoload');
