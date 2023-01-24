<?php

namespace Scuba\Web\Controller;

use Scuba\Web\View\View;

require_once "vendor/autoload.php";

class Controller
{
    public static function do_register($page): void
    {
        $template = View::render_view($page);
        echo $template;
        header(header: '', response_code: 200);
    }

    public static function do_login($page): void
    {
        $template = View::render_view($page);
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