<?php defined('APP') or die("Access denied.");
/* common.php
Holds common code required by all files.
*/
require_once('config.php');

define('DEBUG', 0);
if (defined('DEBUG')) {
    ini_set('display_errors', 'On');
}

// $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);

session_start();

/* redirect_inside
Used to redirect to a path under the site's base url.
*/
function redirect_inside($url)
{
    header('Location: ' . BASE_URL . $url);
}

function redirect($url)
{
    header("Location: $url");
}

function do_authentication()
{
    if (!isset($_SESSION['username'])) {
        redirect_inside('login.php');
    }
}

/*
Allows the safe printing of data without a risk of SQL injection.
*/
function echo_safe($x)
{
    echo htmlspecialchars($x);
}

class Dummy
{
    function __construct()
    {
        if (func_num_args()) {
            $this->val = func_get_arg(0);
        } else {
            $this->val = "";
        }
    }

    function __get($name)
    {
        return $this->val;
    }

    function __set($name, $value)
    {
        $this->$name = $value;
    }
}
