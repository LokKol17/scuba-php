<?php

use Scuba\Web\Crud\Crud;
use Scuba\Web\Model\User;

require_once "../vendor/autoload.php";

$person = $_POST['person'];

$user = new User(
    $person['name'],
    $person['email'],
    $person['password'],
);

Crud::crud_create($user);

header('Location: /?page=login');
die();