<?php

namespace Scuba\Web\Auth;

use Scuba\Web\Crud\Crud;

class Auth
{
    public function authentication($email, $password): bool
    {
        $emails = Crud::crud_getEmails();
        if (!in_array($email, $emails)) {
            $_SESSION['message'] = 'Email ou senha incorretos';
            throw new \DomainException('Email ou senha incorretos');
        }
        $users = Crud::crud_getUsers();
        foreach ($users as $user) {
            if ($user['email'] !== $email) {
                continue;
            }
            if (!password_verify($password, $user['password'])) {
                $_SESSION['message'] = 'Email ou senha incorretos';
                throw new \DomainException('Email ou senha incorretos');
            }
        }

        return true;
    }

}