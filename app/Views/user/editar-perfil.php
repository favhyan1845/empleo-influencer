<div class="container">
        <div class="row">
            <?php
            if($msg): ?>
                <div class="alert <?= $alertClass ?>" role="alert">
                <?= $msg ?>
                </div>
            <?php endif; ?>
        </div>
        <h1 class="d-flex justify-content-center py-3">Mi Perfil</h1>
        <div class="col-md-12">
            <?php
            if(!empty($usuario[0]['ImageName'])){?>
            <img src="<?=  'public/'. $usuario[0]['ImageName']; ?>" class="image-profile rounded-circle">
            <?php } ?>

        <p>En esta sección usted como Cliente puede conocer y editar los datos del perfil para mantener actualizada la información que es usada en la plataforma.</p>
        <form class="row g-3 form-profile" action="<?= base_url('/updateUser') ?>" method="POST" enctype="multipart/form-data">
            <?php
            foreach ($usuario as $user):
                if(!empty($user['Gender'])){
                    if($user['Gender'] =='f' || $user['Gender'] ==''){
                        $gender= "Femenino";
                    }else if($user['Gender'] =='m'){
                        $gender = "Masculino";
                    }else if($user['Gender'] =='o'){
                        $gender = "Otro";
                    }else if($user['Gender'] =='n'){
                        $gender = "No definido";
                    }
                }
                ?>
                <div class="col-md-5">
                <p><strong><label><?= (session('type') == 2) ? "Empresa" : "Usuario" ?></label></strong>
                <input type="text" name="username" class="form-control input-text" value="<?= ($user['UserName'] == '') ? "" : $user['UserName']; ?>"></p>
                <p><strong><label>Nombres</label></strong>
                <input type="text" name="fname" class="form-control input-text" value="<?= ($user['FName'] == '') ? "" : $user['FName']; ?>"></p>
                <p><strong><label>Apellidos</label></strong>
                <input type="text" name="lname" class="form-control input-text" value="<?= ($user['LName'] == '') ? "" : $user['LName']; ?>"></p>
                <p><strong><label>Email</label></strong>
                <input type="email" name="email" class="form-control input-text" value="<?= ($user['Email'] == '') ? "" : $user['Email']; ?>"></p>
                <p><strong><label>Imagen de perfil</label></strong>
                    <input type="file" name="imagename" class="form-control input-text">

                    <?php
                        if ( session('type') != 2 ):
                    ?></p>
                <p><strong><label>Genero</label></strong>
                    <select name="gender" class="form-control input-text" required>
                    <option value="<?= ($gender == '') ? "f" : $user['Gender'];  ?>"><?= ($gender == '') ? "Femenino" : $gender; ?></option>
                    <?php
                        if($user['Gender'] =='f' || $user['Gender'] ==''){
                            echo  '<option value="m">Masculino</option>';
                            echo  '<option value="o">Otro</option>';
                            echo  '<option value="n">No definido</option>';
                        }else if($user['Gender'] =='m'){
                            echo  '<option value="f">Femenino</option>';
                            echo  '<option value="o">Otro</option>';
                            echo  '<option value="n">No definido</option>';
                        }else if($user['Gender'] =='o'){
                            echo  '<option value="m">Masculino</option>';
                            echo  '<option value="f">Femenino</option>';
                            echo  '<option value="n">No definido</option>';
                        }else if($user['Gender'] =='n'){
                            echo  '<option value="m">Masculino</option>';
                            echo  '<option value="f">Femenino</option>';
                            echo  '<option value="o">Otro</option>';
                        }?>
                    </select></p>

                    <p><strong><label>Fecha de nacimiento</label></strong>
                    <input type="date" name="birthday" class="form-control input-text" required value="<?= ($user['Birthday'] == '') ? "" : $user['Birthday']; ?>">
                    <?php
                        endif;
                    ?>
                    </p>
                </div>
                <div class="col-md-5">
                <p><strong><label>País</label></strong>
                    <select name="countryName" class="form-control input-text" required>
                    <option value="<?= ($user['CountryName'] == '0') ? "" : $user['CountryName']; ?>"><?= ($user['CountryName'] == '0') ? "Seleccionar" : $user['CountryName']; ?></option>
                    <?php foreach ($countries as $country): ?>
                        <option value="<?= $country['CountryName']; ?>"><?= $country['CountryName']; ?></option>
                    <?php endforeach; ?>
                    </select></p>
                    <p><strong><label>Ciudad</label></strong>
                    <select name="cityName" class="form-control input-text" required="">
                    <option value="<?= ($user['CityName'] == '0') ? "" : $user['CityName']; ?>"><?= ($user['CityName'] == '0') ? "Seleccionar" : $user['CityName']; ?></option>
                    <?php foreach ($cities as $city): ?>
                        <option value="<?= $city['CityName']; ?>"><?= $city['CityName']; ?></option>
                    <?php endforeach; ?>
                    </select></p>
                    <p><strong><label>Dirección</label></strong>
                    <input type="text" name="address" class="form-control input-text" value="<?= ($user['Address'] == '') ? "" : $user['Address']; ?>"></p>
                    <p><strong><label>Codigo postal</label></strong>
                    <input type="text" name="postalCode" class="form-control input-text" value="<?= ($user['PostalCode'] == '') ? "" : $user['PostalCode']; ?>">
                    </p>
                </div>
                <div class="col-md-12">
                <p><strong><label>Biografia</label></strong>
                    <textarea name="bio" class="form-control input-text"><?= ($user['Biography'] == '') ? "" : $user['Biography']; ?></textarea></p>
                </div>
                <?php
            endforeach; ?>
            <br>

            <div class="col-md-12">
                <?= view('categorias/index',[ 'categorias' => $categorias]); ?>
            </div>
            <div class="col-md-12">
                <?= view('redes/index',[ 'categorias' => $categorias]); ?>
            </div>
                <?php
                if(session('type') == 1 || session('type') == 3):
                ?>
                <p class="col-md-12">
                    <div class="col-md-5">
                        <?= $btn_add ?>
                    </div>
                </p>
                <?php
                endif;
                ?>
            <?php
                if(session('type') == 1 || session('type') == 3):
                if(!empty($experiences) || $experiences != ""){
                    ?>
                    <div class="col-md-12 scroll-box">
                        <?=  view('exp/index',['experiences' => $experiences]); ?>
                    </div>
            <?php
                }else{
                ?>
                    <div class="col-md-12">
                        <h3>No hay experiencias aún</h3>
                    </div>
                <?php
                };
            endif;
            ?>
            <?= $btn ?>
            </form>
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