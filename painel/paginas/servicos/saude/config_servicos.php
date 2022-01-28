<?php
include "../../../../lib/includes.php";

$urlServicos = 'paginas/servicos/saude';

$_SESSION['categoria'] = (($_GET['categoria'])?:$_SESSION['categoria']);

$categoria = (($_GET['categoria'])?:$_SESSION['categoria']);
list($cat_desc) = mysql_fetch_row(mysql_query("select descricao from categorias where codigo = '{$categoria}'"));


function getEsfera()
{
    return [
        'Municipal', 'Estadual'
    ];
}

function getSituacao()
{
    return [
        'tramitacao' => 'Tramitação',
        'retorno' => 'Retorno',
        'concluido' => 'Concluído',
    ];
}

function getSituacaoOptions($situacao)
{
    $list = getSituacao();
    return $list[$situacao];
}
