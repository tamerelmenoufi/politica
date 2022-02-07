<?php
    include "../../../lib/includes.php";
?>
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-body">
                <div graficos opc="geral"></div>
            </div>
        </div>
    </div>

    <div class="col-md-8 offset-md-2" style="margin-top:20px;">
        <div class="card">
            <div class="card-body">
                <div graficos opc="bairros"></div>
            </div>
        </div>
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