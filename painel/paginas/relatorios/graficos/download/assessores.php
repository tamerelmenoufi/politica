<?php
    include "../../../../../lib/includes.php";

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=assessores.csv');

    $md5  = md5(date("YmdHis").$_SERVER["PHP_SELF"]);

    $query = "SELECT a.nome AS descricao, COUNT(*) AS qt FROM servicos s "
    ."INNER JOIN assessores a ON a.codigo = s.assessor "
    ."GROUP BY a.nome ORDER BY qt DESC";

    #$query = "select b.tipo, count(*) as qt from servicos a left join servico_tipo b on a.tipo = b.codigo group by a.tipo";
    $result = mysql_query($query);
    $n = mysql_num_rows($result);

    $i=0;
    while($d = mysql_fetch_object($result)){
        $rotulo[] = $d->descricao;
        $qt[] =  $d->qt;
        $lg[] = $d->descricao; //$Legenda[$i];
        $bg[] = $Bg[$i];
        $bd[] = $Bd[$i];
    $i++;
    }
?>

Assessores;Quantidade
    <?php
      for($i = 0; $i < count($lg); $i++){
    ?>
<?=$rotulo[$i]?>;<?=$qt[$i]?>
    <?php
      }
    ?>
