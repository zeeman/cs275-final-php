<?php defined('APP') or die("Access denied.");
/* common.php
Holds common code required by all files.
*/
require_once('config.php');

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

function do_authentication()
{
    if (!isset($_SESSION['username'])) {
        redirect_inside('login.php');
    }
}
