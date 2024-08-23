<?php
if($experiences !== false){
    foreach($experiences as $exp){
        ?>
<div class="d-grid gap-3 card my-2">
    <div class="card-header">
        <h5><?php echo $exp['name_camp']; ?></h5>
    </div>
    <div class="card-body">
        <?php echo $exp['Description']; ?>
        <br>
        <br>
        <div class="row float-end">
            <div class="col-md-6 col-xs-6">
                <a href="<?= site_url('editar-experiencia/'.$exp['id']) ?>"
                    class="btn btn-outline-dark btn-lg px-5 py-3 fs-6 fw-bolder">Editar</a>
            </div>
            <div class="col-md-2 col-xs-6">
                <button type="button" class="btn btn-outline-dark btn-lg px-5 py-3 fs-6 fw-bolder" data-toggle="modal"
                    data-target="#modalEliminar" data-id="<?php echo $exp['id'] ?>" onclick="handleDataId(this)">Eliminar</button>
            </div>
        </div>
        </p>
    </div>
</div>
<?php
    }
}
?>