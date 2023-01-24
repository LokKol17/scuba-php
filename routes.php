<?php

use Scuba\Web\Controller\Controller;

require_once "vendor/autoload.php";

$page = $_GET['page'];

switch ($page) {
    case 'login':
        Controller::do_login($page);
        break;
    case 'register':
        Controller::do_register($page);
        break;
    default:
        Controller::do_not_found($page);
}

die();