<?php

namespace Scuba\Web\Controller;

use Scuba\Web\Crud\Crud;
use Scuba\Web\View\View;

require_once __DIR__ . "/../../vendor/autoload.php";

class Controller
{
    public static function do_register($page, $from): void
    {
        $message = null;
        if (isset($_POST['person'])) {
            $validator = new RequestValidator($_POST['person']);
            try {
                if ($validator->validateRegister() === false) {
                    header('Location: /?page=register');
                } else {
                    Crud::crud_create($validator->validateRegister());
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

        if ($from == 'register') {
            $messagemSucesso = 'Você ainda precisa confirmar seu email!';
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
}