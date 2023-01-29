<?php

use Scuba\Web\Auth\Auth;
use Scuba\Web\Controller\Controller;
use Scuba\Web\Crud\Crud;

require_once "vendor/autoload.php";

session_start();

$page = $_GET['page'] ?? 'default';
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
    case 'logout':
        Controller::do_logout();
        break;
    case 'delete-account':
        Controller::do_delete_account();
        break;
    case 'home':
    case 'default':
        if (userIsLogged()) {
            Controller::do_home('home');
        } else {
            Controller::do_login('login', $from);
        }
        break;
    default:
        Controller::do_not_found();
    break;
}

function userIsLogged(): bool
{
    $users = Crud::crud_getUsers();
    foreach ($users as $user) {
        if (isset($_SESSION['auth']) && str_contains($_SESSION['auth'], $user['name']) && str_contains($_SESSION['auth'], $user['email']))
            return true;
    }
    return false;
}
