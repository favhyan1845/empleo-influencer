<div class="container">
		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-8">
			<h1>Campaña</h1>
                <form action="<?php echo base_url('/insert_campaign') ?>" method="POST">
                    <label>Nombre Campaña</label>
                    <input type="text" name="campana_name" class="form-control" required>
                    <label>Fecha de caducidad de la campaña</label>
                    <input type="date" name="date_campana" class="form-control" required>
                    <label>Escribe la campaña</label>
                    <textarea name="campana" class="form-control"></textarea>
                    <br>
                    <div class="col-md-12">
                        <?= view('categorias/campaigns',[ 'categorias' => $categorias]); ?>
                    </div>
                    <br>
                    <div class="col-md-12">
                        <?= view('categorias/campaigns-ext',[ 'categorias_ext' => $categorias_ext]); ?>
                    </div>
                    <button class="btn btn-primary">Entrar</button>
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
