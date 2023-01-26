<?php

namespace Scuba\Web\Crud;

use Scuba\Web\Model\User;

class Crud
{
    public static function crud_create(User $user)
    {
        $dataPath = '../data/users.json';
        $content = [
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword()
        ];

        $file = file_get_contents($dataPath);
        $data = json_decode($file);
        $data[] = $content;
        $data = json_encode($data);
        file_put_contents($dataPath, $data);
    }
}