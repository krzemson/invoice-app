<?php

function autoload($class)
{
    $className = str_replace('\\', '/', $class);

    if (file_exists($className.'.php')) {
        require_once($className.'.php');
    } elseif (file_exists('../'.$className.'.php')) {
        require_once("../".$className.'.php');
    } else {
        require_once("../../".$className.'.php');
    }

}

spl_autoload_register('autoload');
