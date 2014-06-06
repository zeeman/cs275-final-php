<?php define('APP', 0);
require_once('common.php');
require_once('templates/base.php');
require_once('models/patron.php');

$patron_base_url = BASE_URL . "patron.php";

$patron_model = new Patron($db);

switch(isset($_GET['action']) ? $_GET['action'] : 'list')
{
    case 'list':

        break;
    case 'edit':
        break;
    case 'delete':
        break;
}