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

    function grafico(obj,opc){
        $.ajax({
            url:"paginas/relatorios/graficos/"+opc+".php",
            success:function(dados){
                    obj.html(dados);
            },
            error:function(){
                alert('Ocorreu um erro!');
            }
        });
    }

    $(function(){
        $("div[graficos]").each(function(){
            obj = $(this);
            opc = $(this).attr("opc");
            console.log(opc);
            grafico(obj,opc);
        });
    })
</script>