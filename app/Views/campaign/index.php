<div class="container ">
		<div class="col-md-12">
			<?= view('campaign/search'); ?>
		</div>
		<?php
		if(session('type') == 1 || session('type') == 2):
		?>
		<p class="col-md-12 d-flex justify-content-center">
			<div class="col-md-5"><a href="<?= base_url('/crear-campaña') ?>" class="btn btn-outline-dark btn-lg px-5 py-3 fs-6 fw-bolder d-inline-flex p-2 bd-highlight">Crear Campaña</a></div>
		</p>
		<?php
		endif;
		?>
	<div class="rod-grid gap-3 w col-md-5 float-sm-start scroll-box lista-campanas">
		<?= view('campaign/lista-campanas',[ 'campaigns' => $campaigns]); ?>
	</div>
	<div class="rod-grid gap-3 w col-md-7 float-sm-start my-2">
		<div class="col-md-11 float-lg-end">
			<?= view('campaign/contenido-caja',[ 'campaign' => $campaign, 'categorias' => $categorias]); ?>
		</div>
	</div>
</div>