<?php

namespace Scuba\Web\Controller;

use Scuba\Web\Crud\Crud;
use Scuba\Web\Crypt\Crypt;
use Scuba\Web\Mail\Mail;
use Scuba\Web\View\View;

require_once __DIR__ . "/../../vendor/autoload.php";

class Controller
{
    public static function do_register($page, $from): void
    {
        $message = null;
        if (isset($_POST['person'])) {
            $_POST['person']['mail_validation'] = false;

            $validator = new RequestValidator($_POST['person']);
            try {
                if ($validator->validateRegister() === false) {
                    header('Location: /?page=register');
                } else {
                    Crud::crud_create($validator->validateRegister());
                    $crypt = Crypt::ssl_crypt($_POST['person']['email']);
                    (new Mail())->sendMail($_POST['person']['email'], $_POST['person']['name'], $crypt);
                    header('Location: /?page=login&from=register');
                }
            } catch (\DomainException $exception) {
                $message = $_SESSION['message'];
            }
        }

        $template = View::render_view($page, $message);
        echo $template;
        header(header: '', response_code: 200);
    }

    public static function do_login($page, $from): void
    {
        $messagemSucesso = null;

        switch ($from) {
            case 'register':
                $messagemSucesso = 'Você ainda precisa confirmar seu email!';
                break;
            case 'mail-validation':
                $messagemSucesso = 'Email confirmado!';
                break;
        }

        $template = View::render_view($page, null, $messagemSucesso );
        echo $template;
        header(header: '', response_code: 200);
    }

    public static function do_not_found(): void
    {
        $page = 'not_found';
        $template = View::render_view($page);
        echo $template;
        header(header: '', response_code: 404);
    }

    public static function do_validation($page, $from, $email = null): void
    {
        if (!password_verify($email, $from)) {
            throw new \DomainException('Ocorreu um erro');
        };
        if (Crud::crud_validateMail($email)) {
            header('Location: /?page=login&from=mail-validation');
        } else {
            throw new \DomainException('Ocorreu um erro');
        }
    }
}