<?php defined('APP') or die('Access denied.');

function as_string($func, $args)
{
    ob_start();
    call_user_func_array($func, $args);
    $result = ob_get_contents();
    ob_end_clean();
    return $result;
}