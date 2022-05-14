<?php

include_once "../lib/includes.php";

?>

<style>

</style>


    <div class="col-md-12">
        <div class="row">

            <div class="col-md-12">


                <table class="table table-hover">
                    <thead>
                        <tr>
                        <th>Local <?=$_GET['data']?></th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>

            <?php
                    $query = "SELECT * FROM `acao_social` where data like '%{$_GET['data']}%'";
                    $result = mysql_query($query);
                    while($d = mysql_fetch_object($result)){

                        $eventos[] = [
                            'id' => $d->codigo,
                            'title' => $d->local,
                            'start' => substr($d->data, 0, 10),
                        ];

            ?>

                        <tr>
                            <td><?=$d->local?></td>
                            <td><?=$d->data?>  === <?=substr($d->data, 5,2)?>/<?=substr($d->data, 8,2)?>/<?=substr($d->data, 0,4)?></td>
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