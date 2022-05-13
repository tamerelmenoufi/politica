<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow flex-row justify-content-between align-items-center">
    <div>
        <a class="navbar-brand mr-4 voltar text-gray-700" href="#" style="font-size: 1.2em">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
    </div>
    <div class="text-gray-700 h4 font-weight-bold mb-0">
        Ação Social
    </div>
</nav>




<script>
    $(function(){
        $(".voltar").click(function(){

            $.ajax({
                url: 'form_acesso.php',
                success: function (response) {
                    $('#palco-agenda').html(response);
                }
            })

        });
    })
</script>