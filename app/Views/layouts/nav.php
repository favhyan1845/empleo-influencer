<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light py-5">
            <div class="container px-5">
                <?php
                    if ( session('Id') == '' ):
                ?>
                <a class="navbar-brand" href="<?php echo base_url('/') ?>"><img src="<?php echo  'public/assets/template/logo/logo.png'; ?>"></a>
                <?php
                    elseif (session('Email')):
                ?>
                <a class="navbar-brand" href="<?php echo base_url('/inicio') ?>"><img src="<?php echo  'public/assets/template/logo/logo.png'; ?>"></a>
                <?php endif; ?>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 small fw-bolder flex-box-left">
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/inicio') ?>"><h3>Campañas</h3></a></li>
                    <li class="nav-item"><a class="nav-link" href="projects.html"><h3>Cursos</h3></a></li>

                    <?php
                        if (!session('Email') && !session('UserName')):
                    ?>
                    <li class="nav-item size-item">
                        <a class="nav-link" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#"><img src="<?php echo  'public/assets/img/user/user-icon.png'; ?>">
                            <h3>INICIAR SESIÓN</h3><br><span>Empresa de influencers</span>
                        </a>
                    </li>
                        <?php
                            elseif (!empty(session('Email')) || !empty(session('UserName'))):
                            ?>
                    <li class="nav-item size-item" aria-expanded="false">
                    <a class="nav-link dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <h3><?php echo (empty(session('UserName')) == '') ? session('UserName') : "Iniciar sesión"; ?></h3>
                    </a>
                    <ul class="dropdown-menu float-end" aria-labelledby="navbarDropdown">
                        <?php
                        if(session('type') == 2){
                            ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/mis-campañas') ?>"><h5>Mis campañas</h5></a></li>
                        <?php }?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/perfil') ?>"><h5>Perfil</h5></a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/editar-perfil') ?>"><h5>Editar Perfil</h5></a></li>
                        <li class="nav-item"><a class="nav-link" href="resume.html"><h5>Mensajes</h5></a></li>
                        <?php
                            if (!empty(session('Email')) || !empty(session('UserName'))):
                        ?>
                        <li class="nav-item">
                            <h5><a class="nav-link" href="<?php echo base_url('/logout') ?>">Salir</a></h5>
                            <?php
                                endif;
                            ?>
                        </li>
                    </ul>
                    </li>
                <?php
                    endif;
                ?>
            </ul>
        </div>
    </div>
</nav>
<div class="row">
    <?php
    if(session()->has('msg')): ?>
        <div class="alert <?= session('alertClass') ?>" role="alert">
        <?= session('msg') ?>
        </div>
    <?php endif; ?>
</div>