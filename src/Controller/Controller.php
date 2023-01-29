<?php

namespace Scuba\Web\Controller;

use Scuba\Web\Auth\Auth;
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
                    SendMail::sendMailTo($_POST['person']);
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
        $mensagemSucesso = null;
        $errorMessage = null;

        switch ($from) {
            case 'register':
                $mensagemSucesso = 'Você ainda precisa confirmar seu email!';
                break;
            case 'mail-validation':
                $mensagemSucesso = 'Email confirmado!';
                break;
            case 'login':
                $errorMessage = 'Email ou senha incorretos';
                break;
        }

        if (isset($_POST['person'])) {
            try {
                $auth = new Auth();
                if ($auth->authentication($_POST['person']['email'], $_POST['person']['password']) === true) {
                    $users = Crud::crud_getUsers();
                    foreach ($users as $user) {
                        if ($user['email'] === $_POST['person']['email']) {
                            $_SESSION['auth'] = $user['name'].'-'.$user['email'];
                        }
                    }
                    header('Location: /?page=home');
                }
            } catch (\DomainException $exception) {
                header('Location: /?page=login&from=login');
            }
        }


        $template = View::render_view($page, $errorMessage, $mensagemSucesso);
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

    public static function do_home(mixed $page)
    {
        $token = $_SESSION['auth'];
        $data = explode('-', $token);
        $template = View::render_view($page, dados: $data);
        echo $template;
        header(header: '', response_code: 200);
    }

    public static function do_logout()
    {
        session_destroy();
        header('Location: /?page=login');
    }

    public static function do_delete_account()
    {
        $token = $_SESSION['auth'];
        $data = explode('-', $token);
        $email = $data[1];
        if (Crud::crud_delete($email)) {
            session_destroy();
            header('Location: /?page=login');
        } else {
            throw new \DomainException('Ocorreu um erro');
        }
    }
}