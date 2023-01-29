<?php

namespace Scuba\Web\Crud;

use Scuba\Web\Model\User;

class Crud
{
    public static function crud_create(User $user)
    {
        $dataPath = __DIR__ . '/../../data/users.json';
        $content = [
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'email-confirm' => false
        ];

        $file = file_get_contents($dataPath);
        $data = json_decode($file, true);
        $data[] = $content;
        $data = json_encode($data);
        file_put_contents($dataPath, $data);
    }

    public static function crud_getEmails(): array|string
    {
        $dataPath = __DIR__ . '/../../data/users.json';

        $file = file_get_contents($dataPath);
        $data = json_decode($file, true);

        $emails = [];
        foreach ($data as $user) {
            $emails[] = strtolower($user['email']);
        }

        return $emails;
    }

    public static function crud_validateMail(string $email): bool
    {
        $emails = self::crud_getEmails();
        if (!in_array($email, $emails)) {
            throw new \DomainException('Email inexistente');
        }
        $dataPath = __DIR__ . '/../../data/users.json';

        $file = file_get_contents($dataPath);
        $data = json_decode($file, true);

        $i = null;
        foreach ($data as $index => $user) {
            if ($user['email'] !== $email) {
                continue;
            }
            $i = $index;
        }

        $data[$i]['email-confirm'] = true;
        file_put_contents($dataPath, json_encode($data));
        return true;
    }

    public static function crud_getUsers(): array
    {
        $dataPath = __DIR__ . '/../../data/users.json';

        $file = file_get_contents($dataPath);
        return json_decode($file, true);
    }

    public static function crud_delete(string $email)
    {
        $dataPath = __DIR__ . '/../../data/users.json';

        $file = file_get_contents($dataPath);
        $data = json_decode($file, true);

        $i = null;
        $set = false;
        foreach ($data as $index => $user) {
            if ($user['email'] !== $email) {
                continue;
            }
            $i = $index;
            $set = true;
        }

        unset($data[$i]);
        file_put_contents($dataPath, json_encode($data));
        return $set;
    }
}