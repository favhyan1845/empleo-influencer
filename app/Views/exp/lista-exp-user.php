<div class="container">
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
        <?php if($type == 0){ ?>
        <h1>Crear experiencia</h1>
        <?php }else if($type == 1){ ?>
        <h1>Editar experiencia</h1>
        <?php } ?>
            <form action="<?= $form ?>" method="POST">
            <?php
            if($experiences !== false){
                foreach($experiences as $exp){
            ?>
            <p><strong><label>Titulo de la experiencia</label></strong>
                <input type="hidden" name="id_exp" value="<?=  $_GET['id']; ?>">
                <input type="text" name="campana_name" class="form-control input-text" required value="<?= ($exp['name_camp'] == '') ? "" : $exp['name_camp']; ?>"></p>
                <p><strong><label>Fecha en que inicio la experiencia</label></strong>
                <input type="date" name="date_campana" class="form-control input-text" required value="<?= ($exp['date_create'] == '') ? "" : $exp['date_create']; ?>"></p>
                <p><strong><label>Describe la experiencia</label></strong>
                <textarea name="campana" class="form-control input-text"><?= ($exp['Description'] == '') ? "" : $exp['Description']; ?></textarea></p>
                <br>
                <?php
                }}else{
                    ?>
                    <p><strong><label>Titulo de la experiencia</label></strong>
                        <input type="text" name="campana_name" class="form-control input-text" required ></p>
                        <p><strong><label>Fecha en que inicio la experiencia</label></strong>
                        <input type="date" name="date_campana" class="form-control input-text" required></p>
                        <p><strong><label>Describe la experiencia</label></strong>
                        <textarea name="campana" class="form-control input-text"></textarea></p>
                        <br>
                        <?php

                }
                ?>
                <div class="col-md-12">
                    <?= view('categorias/campaigns',[ 'categorias' => $categorias]); ?>
                </div>
                <br>
                <p>
                    <?= $btn ?>
                </p>
            </form>
        </div>
        <div class="col-sm-2"></div>
    </div>
    <div class="row">
        <?php
        if(session()->has('msg')): ?>
            <div class="alert <?= session('alertClass') ?>" role="alert">
            <?= session('msg') ?>
            </div>
        <?php endif; ?>
    </div>
</div>
