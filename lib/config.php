<?php

if (session_id() === "") {
    session_start();
}

function getUrl()
{
    if (isset($_SERVER['HTTPS'])) {
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    } else {
        $protocol = 'http';
    }


    if ($_SERVER['HTTP_HOST'] === 'localhost') return $protocol . "://localhost/dsv/politica/";

    #return $protocol . "://" . $_SERVER['HTTP_HOST'];
    return 'http://politica.mohatron.com/';
}

$caminho_vendor = getUrl() . "lib/vendor";


if($_SESSION['usuario']){
    $ConfP =  $_SESSION['usuario'];
    $ConfP = $ConfP->permissoes;
    $ConfP = explode(",",$ConfP);
    for($i=0;$i<count($ConfP);$i++){
        list($Ind, $Val) = explode(" - ",$ConfP[$i]);
        $ConfPermissoes[trim($Ind)] = trim($Val);
    }
}