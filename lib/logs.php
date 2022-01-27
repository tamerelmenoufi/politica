<?php


function sis_logs($codigo, $tabela, $query, $descricao = '')
{
    $usuario = $_SESSION['usuario']['codigo'];
    $operacao = strtoupper(trim(explode(' ', $query)[0]));
    $query = mysql_real_escape_string($query);
    $descricao = "[USUARIO] [{$operacao}] {$descricao}";

    $query_log = "INSERT INTO sis_logs "
        . "SET usuario = '{$usuario}', registro = '{$codigo}', operacao = '{$operacao}', query = '{$query}', "
        . "descricao = '{$descricao}', tabela = '{$tabela}', data = NOW()";

    mysql_query($query_log);
}