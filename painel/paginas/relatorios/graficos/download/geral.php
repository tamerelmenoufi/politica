<?php
    include "../../../../lib/includes.php";

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=geral.csv');

    $md5  = md5(date("YmdHis").$_SERVER["PHP_SELF"]);

    $query = "select b.tipo, count(*) as qt from servicos a left join servico_tipo b on a.tipo = b.codigo group by a.tipo ORDER BY qt DESC";
    $result = mysql_query($query);
    $i=0;
    while($d = mysql_fetch_object($result)){
        $rotulo[] = $d->tipo;
        $qt[] =  $d->qt;
        $lg[] = $Legenda[$i];
        $bg[] = $Bg[$i];
        $bd[] = $Bd[$i];
    $i++;
    }
?>
Legenda;Descrição;Quantidade
    <?php
      for($i = 0; $i < count($lg); $i++){
    ?>
<?=$lg[$i]?>;<?=$rotulo[$i]?>;<?=$qt[$i]?>
    <?php
      }

?>
