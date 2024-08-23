<?php
    foreach($campaigns as $camp){
        ?>
            <div class="d-grid gap-3 card my-2 card_<?= $camp['id']; ?>">
                <div class="card-header">
                    <h5><?php echo $camp['name_camp']; ?></h5>
                </div>
                <div class="card-body">
                    <p>
                        <label><strong>Fecha finalización:&nbsp;</strong></label><?php echo $camp['date_finish']; ?>
                    </p>
                    <p><strong>Descripción: </strong><br>
                        <?php echo $camp['Description']; ?>
                        <br>
                        <br>
                        <a href ="javascript:campaign(<?php echo "'".base64_encode($camp['id'])."'"; ?>)" class="btn btn-outline-dark btn-lg px-5 py-3 fs-6 fw-bolder float-end">Ver más</a>
                    </p>
                </div>
            </div>
        <?php
    }
?>