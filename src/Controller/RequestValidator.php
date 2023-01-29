<?php

namespace Scuba\Web\Controller;

use Scuba\Web\Crud\Crud;
use Scuba\Web\Model\User;

class RequestValidator
{
    private array $person;
    public function __construct(array $person)
    {
        $this->person = $person;
        $this->person['email'] = strtolower($this->person['email']);
    }

    public function validateRegister(): User|false
    {
        $emails = Crud::crud_getEmails();

        if ($this->person['password'] !== $this->person['password-confirm'] || mb_strlen($this->person['password']) < 10) {
            $_SESSION['message'] = 'A senha deve conter 10 caracteres e coincidirem';
            throw new \DomainException('Dados inválidos');
        } elseif (in_array($this->person['email'], $emails)) {
            $_SESSION['message'] = 'Esse email ou nome de usuario já existe';
            throw new \DomainException('Email já em uso');
        }

        return new User(
            $this->person['name'],
            $this->person['email'],
            password_hash($this->person['password'], PASSWORD_BCRYPT),
        );
    }

//    public function validateLogin(): bool
//    {
//
//    }
}