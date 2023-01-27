<?php

use Scuba\Web\Controller\Controller;

require_once "vendor/autoload.php";

session_start();

$page = $_GET['page'];
$from = null;
$email = null;

if (isset($_GET['from'])) {
    $from = $_GET['from'];
}
if (isset($_GET['email'])) {
    $email = $_GET['email'];
}

switch ($page) {
    case 'login':
        Controller::do_login($page, $from);
        break;
    case 'register':
        Controller::do_register($page, $from);
        break;
    case 'mail-validation':
        Controller::do_validation($page, $from, $email);
        break;
    default:
        Controller::do_not_found($page);
}

session_destroy();
die();