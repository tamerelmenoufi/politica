<button xls type="button" class="btn btn-primary btn-sm" style="opacity:0.2">
    <i class="fa-solid fa-plus"></i>
</button>

<script>
    $(function(){
        $("button[xls]").click(function(){
            busca = $('input[type="search"]').val();
            alert(busca)
        });
    })
</script>