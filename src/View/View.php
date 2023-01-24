<?php

namespace Scuba\Web\View;

require_once "vendor/autoload.php";
class View
{
    public static function render_view(string $template): null|string
    {
        $template = $template . '.view';
        return file_get_contents( 'view/' . $template);
    }
}