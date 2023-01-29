<?php

namespace Scuba\Web\View;

require_once __DIR__ . '/../../vendor/autoload.php';
class View
{
    public static function render_view(string $template,
                                       ?string $mensagem = null,
                                       ?string $mensagemSucesso = null,
                                       ?array $dados = null): null|string
    {
        $template = $template . '.view';
        $html = file_get_contents( __DIR__ . '/../../view/' . $template);
        $pos = strpos($html, 'Mensagem de Erro');
        if (is_null($mensagem)) $mensagem = '';
        if (is_null($mensagemSucesso)) $mensagemSucesso = '';
        $html = str_replace('Mensagem de Erro', $mensagem, $html);
        $html = str_replace('Mensagem de Sucesso', $mensagemSucesso, $html);
        if (is_null($dados)) return $html;
        $html = str_replace('{{field_name}}', $dados[0], $html);
        $html = str_replace('{{field_email}}', $dados[1], $html);
        return $html;
    }
}