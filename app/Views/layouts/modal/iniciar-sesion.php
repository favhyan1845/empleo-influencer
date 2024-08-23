<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Iniciar sesión</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <!-- Header form register-->
        <div class="d-flex justify-content-center mt-12 mt-xxl-0">
                <form class="col-xxl-12" action="<?php echo base_url('/login') ?>" method="POST">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control" required="">
                    <label>password</label>
                    <input type="password" name="password" class="form-control" required="">
                    <br>
                    <button class="btn btn-outline-dark btn-lg px-5 py-3 fs-6">Entrar</button>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
</div>