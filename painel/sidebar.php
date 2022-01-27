<ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion menus" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">POLITICA</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dahboard -->
    <li class="nav-item active">
        <a class="nav-link" href="./">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span></a>
    </li>


    <!-- Divider  -->
    <!-- <hr class="sidebar-divider"> -->

    <!-- Heading -->
    <!-- <div class="sidebar-heading">
        Sistema
    </div> -->

    <!--Nav item - Cadastros-->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#solicitacoes"
           aria-expanded="true" aria-controls="solicitacoes">
            <i class="fa-solid fa-user-pen"></i>
            <span>Solicitações</span>
        </a>
        <div id="solicitacoes" class="collapse" aria-labelledby="headingUtilities"
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Serviços</h6>
                <?php
                if(in_array('Certidão de Nascimento - Alterar', $ConfPermissoes)){
                ?>
                <a class="collapse-item" href="#" url="paginas/servicos/cn/index.php">Certidão de Nascimento</a>
                <?php
                }
                if(in_array('Registro Geral - Alterar', $ConfPermissoes)){
                ?>
                <a class="collapse-item" href="#" url="paginas/servicos/rg/index.php">Registro Geral </a>
                <?php
                }
                if(in_array('CRAS - Alterar', $ConfPermissoes)){
                ?>
                <a class="collapse-item" href="#" url="paginas/servicos/cras/index.php">CRAS</a>
                <?php
                }
                if(in_array('CR - Alterar', $ConfPermissoes)){
                ?>
                <a class="collapse-item" href="#" url="paginas/servicos/cr/index.php">CR</a>
                <?php
                }
                if(in_array('Psicologia - Alterar', $ConfPermissoes)){
                ?>
                <a class="collapse-item" href="#" url="paginas/servicos/psicologia/index.php">Psicologia</a>
                <?php
                }
                if(in_array('Odontologia - Alterar', $ConfPermissoes)){
                ?>
                <a class="collapse-item" href="#" url="paginas/servicos/odontologia/index.php">Odontologia</a>
                <?php
                }
                if(in_array('Jurídico - Alterar', $ConfPermissoes)){
                ?>
                <a class="collapse-item" href="#" url="paginas/servicos/juridico/index.php">Jurídico</a>
                <?php
                }
                if(in_array('Saúde - Alterar', $ConfPermissoes)){
                ?>
                <a class="collapse-item" href="#" url="paginas/servicos/saude/index.php">Saúde</a>
                <?php
                }
                ?>
            </div>
        </div>
    </li>

    <!--Nav item - Cadastros-->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#eventos"
           aria-expanded="true" aria-controls="eventos">
            <i class="fa-solid fa-calendar"></i>
            <span>Eventos</span>
        </a>
        <div id="eventos" class="collapse" aria-labelledby="headingUtilities"
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Tipos</h6>
                <?php
                if(in_array('Ação Social - Alterar', $ConfPermissoes)){
                ?>
                <a remove class="collapse-item" href="#" url="paginas/cadastros/acao_social/index.php">Ação Social</a>
                <?php
                }
                if(in_array('Ofícios - Alterar', $ConfPermissoes)){
                ?>
                <a remove class="collapse-item" href="#" url="paginas/cadastros/oficios/index.php">Ofícios</a>
                <?php
                }
                ?>
            </div>
        </div>
    </li>


    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#cadastros"
           aria-expanded="true" aria-controls="cadastros">
            <i class="fa-solid fa-users-gear"></i>
            <span>Cadastros</span>
        </a>
        <div id="cadastros" class="collapse" aria-labelledby="headingUtilities"
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Tipos</h6>
                <?php
                if(in_array('Assessores - Alterar', $ConfPermissoes)){
                ?>
                <a class="collapse-item" href="#" url="paginas/cadastros/assessores/index.php">Assessores</a>
                <?php
                }
                if(in_array('Beneficiados - Alterar', $ConfPermissoes)){
                ?>
                <a class="collapse-item" href="#" url="paginas/cadastros/beneficiados/index.php">Beneficiados</a>
                <?php
                }
                ?>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#configuracoes"
           aria-expanded="true" aria-controls="configuracoes">
            <i class="fas fa-fw fa-cog"></i>
            <span>Configurações</span>
        </a>
        <div id="configuracoes" class="collapse" aria-labelledby="headingUtilities"
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Tabelas</h6>
                <?php
                if(in_array('Fontes Locais - Alterar', $ConfPermissoes)){
                ?>
                <a class="collapse-item" href="#" url="paginas/cadastros/fontes_locais/index.php">Fontes Locais</a>
                <?php
                }
                if(in_array('Municípios - Alterar', $ConfPermissoes)){
                ?>
                <a class="collapse-item" href="#" url="paginas/cadastros/municipios/index.php">Municípios</a>
                <?php
                }
                if(in_array('Secretárias - Alterar', $ConfPermissoes)){
                ?>
                <a class="collapse-item" href="#" url="paginas/cadastros/secretarias/index.php">Secretárias</a>
                <?php
                }
                if(in_array('Tipo de Serviço - Alterar', $ConfPermissoes)){
                ?>
                <a class="collapse-item" href="#" url="paginas/cadastros/tipo_servico/index.php">Tipo de Serviço</a>
                <?php
                }
                if(in_array('Especialidades - Alterar', $ConfPermissoes)){
                ?>
                <a class="collapse-item" href="#" url="paginas/cadastros/especialidades/index.php">Especialidades</a>
                <?php
                }
                //if(in_array('Usuários - Alterar', $ConfPermissoes)){
                ?>
                <a class="collapse-item" href="#" url="paginas/cadastros/usuarios/index.php">Usuários</a>
                <?php
                //}
                if(in_array('Permissoes - Alterar', $ConfPermissoes)){
                ?>
                <a class="collapse-item" href="#" url="paginas/cadastros/permissoes/index.php">Permissoes</a>
                <?php
                }
                ?>
            </div>
        </div>
    </li>


    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities1"
           aria-expanded="true" aria-controls="collapseUtilities1">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Cadastros</span>
        </a>
        <div id="collapseUtilities1" class="collapse" aria-labelledby="headingUtilities"
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Cadastros</h6>
                <a class="collapse-item" href="#" url="paginas/cadastros/acao_social/index.php">Ação Social</a>
                <a class="collapse-item" href="#" url="paginas/cadastros/assessores/index.php">Assessores</a>
                <a class="collapse-item" href="#" url="paginas/cadastros/beneficiados/index.php">Beneficiados</a>
                <a class="collapse-item" href="#" url="paginas/cadastros/fontes_locais/index.php">Fontes Locais</a>
                <a class="collapse-item" href="#" url="paginas/cadastros/municipios/index.php">Municípios</a>
                <a class="collapse-item" href="#" url="paginas/cadastros/secretarias/index.php">Secretárias</a>
                <a class="collapse-item" href="#" url="paginas/cadastros/oficios/index.php">Ofícios</a>
                <a class="collapse-item" href="#" url="paginas/cadastros/tipo_servico/index.php">Tipo de Serviço</a>
                <a class="collapse-item" href="#" url="paginas/cadastros/servicos/index.php">Serviços</a>
            </div>
        </div>
    </li> -->

    <!-- Nav Item - Configuração -->
    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Configurações</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Configurações:</h6>
                <a class="collapse-item" href="buttons.html">Buttons</a>
                <a class="collapse-item" href="cards.html">Cards</a>
            </div>
        </div>
    </li> -->


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>