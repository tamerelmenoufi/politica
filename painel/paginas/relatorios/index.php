<?php
    include "../../../lib/includes.php";
?>
<div class="row">
<div class="col-6">
        <div graficos opc="geral"></div>
    </div>
    <div class="col-6">
        <div graficos opc="bairros"></div>
    </div>
</div>




<script>
    $(function(){
        $("div[graficos]").each(function(){
            opc = $(this).attr("opc");
            $.ajax({
                url:"paginas/relatorios/grafios/"+opc+".php",
                success:function(dados){
                     $(this).html(dados);
                }
            });
        });
    })
</script>