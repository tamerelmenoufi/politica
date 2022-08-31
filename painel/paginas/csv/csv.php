<?php

    include("./config_csv.php");

    // beneficido  b.nome
    // assessor    a.nome
    // data_agenda s.data_agenda
    // situacao    s.situacao
    // local       lf.descricao
    // local_responsavel s.local_responsavel

    $where = false;
    if(trim($_GET['busca'])){
        $opc = explode(" ",$_GET['busca']);
        $nivel_campo = [];
        for($i=0;$i<count($opc);$i++){
            $b = trim($opc[$i]);
            $nivel_campo['beneficido'][] = "b.nome like '%{$b}%'";
            $nivel_campo['assessor'][] = "a.nome like '%{$b}%'";
            $nivel_campo['data_agenda'][] = "s.data_agenda like '%".dataMysql($b)."%'";
            $nivel_campo['situacao'][] = "s.situacao like '%{$b}%'";
            $nivel_campo['local'][] = "lf.descricao like '%{$b}%'";
            $nivel_campo['local_responsavel'][] = "s.local_responsavel like '%{$b}%'";
        }
        $nivel_where = [];
        foreach($nivel_campo as $ind => $val){
            $nivel_where[] = "(".implode(" or ", $val).")";
        }
        $where = implode(" AND ", $nivel_where);
    }


    if($where) $_SESSION['query_xls'] = str_replace("WHERE", "WHERE {$where} AND ",$_SESSION['query_xls']);

    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";
    echo "<hr>";
    echo "<pre>";
    print_r($_GET);
    echo "</pre>";

