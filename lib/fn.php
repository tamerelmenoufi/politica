<?php

function sis_logs($tabela, $codigo, $query, $operacao = null)
{
    $usuario = $_SESSION['usuario']['codigo'];
    $operacao = $operacao ?: strtoupper(trim(explode(' ', $query)[0]));
    $query = mysql_real_escape_string($query);
    $data = date("Y-m-d H:i:s");

    $query_log = "INSERT INTO sis_logs "
        . "SET usuario = '{$usuario}', registro = '{$codigo}', operacao = '{$operacao}', query = '{$query}', "
        . "tabela = '{$tabela}', data = '{$data}'";

    mysql_query($query_log);
}

function exclusao($tabela, $codigo, $fisica = false)
{
    if ($fisica) {
        $query = "DELETE FROM {$tabela} WHERE codigo = '{$codigo}'";
    } else {
        $query = "UPDATE {$tabela} SET deletado = '1' WHERE codigo = '{$codigo}'";
    }

    if (mysql_query($query)) {
        sis_logs($codigo, $query, $tabela, 'DELETE');
        return true;
    } else {
        return false;
    }
}

function ListaLogs($tabela, $registro){
    $Query = [];
    $query = "select a.*, b.nome from sis_logs a left join usuarios b on a.usuario=b.codigo where a.tabela = '{$tabela}' and a.registro = '{$registro}' order by a.codigo asc";
    $result = mysql_query($query);
    while($d = mysql_fetch_object($result)){

        switch($d->operacao){

            case 'INSERT':{
                $Query[] = InsertQuery($d->query);
                break;
            }
            case 'UPDATE':{
                $Query[] = UpdateQuery($d->query);
                break;
            }

        }

    }
    return $Query;
}

function InsertQuery($query){
    list($l, $d) = explode("SET", $query);
    $d = str_replace("=","=>", $d);
    return "[{$d}]";
}

function UpdateQuery($query){
    list($l, $d) = explode("SET", $query);
    list($l, $d) = explode("WHERE", $d);
    $d = str_replace("=","=>", $d);
    return "[{$d}]";
}