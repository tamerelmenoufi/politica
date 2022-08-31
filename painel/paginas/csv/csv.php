<?php

    // header('Content-Type: application/csv');
    // header('Content-Disposition: attachment; filename=example.csv');
    // header('Pragma: no-cache');

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
            if(dataMysql($b)){
            $nivel_campo['data_agenda'][] = "s.data_agenda like '%".dataMysql($b)."%'";
            }
            if(Sts($b)){
            $nivel_campo['situacao'][] = "s.situacao like '%{$b}%'";
            }
            $nivel_campo['local'][] = "lf.descricao like '%{$b}%'";
            $nivel_campo['local_responsavel'][] = "s.local_responsavel like '%{$b}%'";
        }
        $nivel_where = [];
        foreach($nivel_campo as $ind => $val){
            $nivel_where[] = " AND (".implode(" or ", $val).")";
        }
        // $where = implode(" AND ", $nivel_where);
    }

    $Query = [];
    $query_xls = [];
    for($i=0;$i<count($nivel_where);$i++){

        $Query[] = str_replace("ORDER BY", $nivel_where[$i] . " ORDER BY ", $_SESSION['query_xls']);

    }

    if($Query) $query_xls = "(".implode(") UNION (", $Query).")";

    // echo "<pre>";
    // print_r($_SESSION);
    // echo "</pre>";
    // echo "<hr>";
    // echo "<pre>";
    // print_r($_GET);
    // echo "</pre>";
    echo $query_xls;

    $result = mysql_query($query_xls);
?>
Beneficiado;Assessor;Data da Agenda;Situação;Local
<?php
    while ($d = mysql_fetch_object($result)){
?>
<?= $d->beneficiado; ?>;<?= $d->assessor; ?>;<?= formata_datahora($d->data_agenda, DATA_HM); ?>;<?= getSituacaoOptions($d->situacao); ?>;<?= $d->lf_descricao . (($d->local_responsavel)?' ('.$d->local_responsavel.')':false); ?>
<?php
    }
?>