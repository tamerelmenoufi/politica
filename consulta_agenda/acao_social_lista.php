<?php

include_once "../lib/includes.php";

?>

<style>

</style>


    <div class="col-md-12">
        <div class="row">

            <div class="col-md-12">

                <h4>Eventos de Ação Social em <?=substr($_GET['data'], 8,2)?>/<?=substr($_GET['data'], 5,2)?>/<?=substr($_GET['data'], 0,4)?></h4>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Local</th>
                            <th>Serviços</th>
                        </tr>
                    </thead>
                    <tbody>

            <?php
                    $query = "SELECT * FROM `acao_social` where data like '%{$_GET['data']}%'";
                    $result = mysql_query($query);
                    while($d = mysql_fetch_object($result)){

                        $q = "select * from acao_social_tipo where codigo in(".($d->servicos?:'0').")";
                        $r = mysql_query($q);
                        $S = [];
                        while($s = mysql_fetch_object($r)){
                            $S[] = $s->tipo;
                        }

            ?>

                        <tr>
                            <td><?=$d->local?></td>
                            <td><?=implode(', ',$S)?></td>
                        </tr>
            <?php
                    }
            ?>
                    </tbody>
                </table>



            </div>
        </div>
    </div>

<script>
    $(function(){




    })
</script>