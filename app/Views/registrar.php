<div class="container">
		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-8">
			<h1>Registrarse</h1>
                <form action="<?php echo base_url('/registration') ?>" method="POST">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                    <label>password</label>
                    <input type="password" name="password" class="form-control" required>
                    <label>Nombres</label>
                    <input type="text" name="FName" class="form-control" required>
                    <label>Apellidos</label>
                    <input type="text" name="LName" class="form-control" required>
                    <?php if($type == 3): ?>
                    <label>Genero</label>
                    <select name="gender" class="form-control" required>
                        <option>Femenino</option>
                        <option>Masculino</option>
                        <option>Otro</option>
                        <option>No definido</option>
                    </select>
                    <label>Fecha de nacimiento</label>
                    <input type="date" name="birthday" class="form-control" required>
                    <?php endif; ?>
                    <input type="hidden" name="type" value="<?php echo $type; ?>">
                    <br>
                    <div class="col-md-12">
                        <?PHP echo view('categorias/index',[ 'categorias' => $categorias]); ?>
                    </div>
                    <button class="btn btn-primary">Registrarse</button>
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
