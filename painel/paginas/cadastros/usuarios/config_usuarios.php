<?php
include "../../../../lib/includes.php";

$urlUsuarios = 'paginas/cadastros/usuarios';

function getSexo()
{
    return [
        'm' => 'Masculino',
        'f' => 'Feminino'
    ];
}

function getSexoOptions($sexo)
{
    $list = getSexo();
    return $list[$sexo];
}
