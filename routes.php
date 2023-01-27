<?php

use Scuba\Web\Controller\Controller;

require_once "vendor/autoload.php";

session_start();

$page = $_GET['page'];
$from = null;
if (isset($_GET['from'])) {
    $from = $_GET['from'];
}

switch ($page) {
    case 'login':
        Controller::do_login($page, $from);
        break;
    case 'register':
        Controller::do_register($page, $from);
        break;
    default:
        Controller::do_not_found($page);
}

session_destroy();
die();