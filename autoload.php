<?php

function autoload($className)
{
    str_replace('\\', '/', $className);

    if (file_exists($className.'.php')) {
        require_once($className.'.php');
    } else {
        require_once("../".$className.'.php');
    }
}

spl_autoload_register('autoload');
