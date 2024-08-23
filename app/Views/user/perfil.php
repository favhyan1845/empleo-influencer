    <div class="container">
            <?php
            foreach ($usuario as $user):
                if($user['Gender'] =='f' || $user['Gender'] ==''){
                    $gender= "Femenino";
                }else if($user['Gender'] =='m'){
                    $gender = "Masculino";
                }else if($user['Gender'] =='o'){
                    $gender = "Otro";
                }else if($user['Gender'] =='n'){
                    $gender = "No definido";
                }
                ?>
                <?php
                if(!empty($usuario[0]['ImageName'])){?>
                <img src="<?php echo  'public/'. $usuario[0]['ImageName']; ?>" class="image-profile rounded-circle">
                <?php } ?>
            <div class="row">
                <div class="col">
                <?php
                        if($user['FName'] !='' ):
                            ?>
                            <h1><?=($user['FName'] == '') ? "" : $user['FName']; ?> <?=($user['LName'] == '') ? "" : $user['LName']; ?></h1>
                            <?php
                        endif;
                    ?>
                    <?php
                        if($user['UserName'] !='' ):
                            ?>
                            <h2><?= ($user['UserName'] == '') ? "" : '@'.$user['UserName']; ?></h2>
                            <?php
                        endif;
                    ?>
                    <?= view('categorias/profile-cat',[ 'categorias' => $categorias]); ?>
                <div class="row">
                    <div class="col">
                    <strong> <?php
                    echo $totalFollow;
                    ?></strong><br>
                    Total followers
                    </div>
                    <div class="col">
                    <strong> <?php
                    echo $user['edad'];
                    ?></strong><br>Años
                    </div>
                    <div class="col">
                    <strong> <?php
                    echo $user['CountryName'];
                    ?></strong><br>País
                    </div>
                    <div class="col">
                    <strong><?php
                    echo $totalER;
                    ?></strong><br>
                    Engagement
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <?PHP echo view('redes/index-profile',[ 'categorias' => $categorias]); ?>
            </div>
            <div class="col-md-12">
            <?php
                if(!empty($user['Biography'])): ?>
                <div class="row">
                    <div class="col">
                    <strong class="d-flex justify-content-center">UN POCO DE MÍ</strong>
                        <p class="d-flex justify-content-center"><?= $user['Biography']; ?></p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-md-12">

                <div class="row">
                    <div class="col">
                    <strong class="d-flex justify-content-center"><?= $titleExp; ?></strong>
                        <p class="d-flex justify-content-center">
                    <?php
                        if(session('type') == 2){
                            ?>
                            <div class="col-md-12 scroll-box">
                                <?=  view('exp/index-campaign',['experiences' => $experiences]); ?>
                            </div>
                    <?php
                        }
                        ?>
                        <?php
                            if(session('type') == 1 || session('type') == 3):
                            if(!empty($experiences) || $experiences != ""){
                                ?>
                                <div class="col-md-12 scroll-box">
                                    <?=  view('exp/index-profile',['experiences' => $experiences]); ?>
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
                    ?></p>
                    </div>
                </div>
            </div>
        </div>
                <div class="col">
                    <?php
                        if($user['LName'] !='' ):
                            ?>
                            <label>Apellidos</label>
                            <span class="badge "></span>
                            <?php
                        endif;
                    ?>
                    <?php
                        if($user['Email'] !='' ):
                            ?>
                            <labeladdress">Email</label>
                            <span class="badge "><?php echo ($user['Email'] == '') ? "" : $user['Email']; ?></span>
                            <?php
                        endif;
                    ?>
                    <?php
                        if ( session('type') != 2 ):
                    ?>
                    <?php
                        if($gender !='' ):
                            ?>
                            <label>Genero</label>
                                <span class="badge "><?php echo ($gender == '') ? "" : $gender ?></span>
                            <?php
                        endif;
                    ?>
                    <?php
                        endif;
                    ?>
                </div>
                <div class="col">
                <?php
                        if($user['CountryName'] !='' ):
                            ?>
                            <label>País</label>
                                <span class="badge "><?php echo ($user['CountryName'] == '') ? "" : $user['CountryName']; ?></span>
                            <?php
                        endif;
                ?>
                <?php
                        if($user['CityName'] !='' ):
                            ?>
                            <label>Ciudad</label>
                                <span class="badge "><?php echo ($user['CityName'] == '') ? "" : $user['CityName']; ?></span>
                            <?php
                        endif;
                ?>

                <?php
                        if($user['Address'] !='' ):
                            ?>
                            <label>Dirección</label>
                                <span class="badge "><?php echo ($user['Address'] == '') ? "" : $user['Address']; ?></span>
                            <?php
                        endif;
                ?>
                <?php
                        if($user['PostalCode'] !='' ):
                            ?>
                            <label>Codigo postal</label>
                                <span class="badge "><?php echo ($user['PostalCode'] == '') ? "" : $user['PostalCode']; ?></span>
                            <?php
                        endif;
                ?>

                </div>
                <?php endforeach; ?>
            <br>

            <div class="col-md-12">
                categorias
            </div>
</div>
