
<?php
	if($campaign != 0): ?>

		<div class="selected-campaing d-grid gap-3 card">
			<div class="card-header">
				<h5><?php echo $campaign[0]['name_camp'] ?></h5>
			</div>
			<div class="card-body">
				<p>
					<label><strong>Fecha inicio:&nbsp;</strong></label><?php echo $campaign[0]['date_create'] ?>
				</p>
				<p>
					<label><strong>Fecha finalización:&nbsp;</strong></label><?php echo $campaign[0]['date_finish'] ?>
				</p>
				<p><strong>Descripción: </strong><br>
					<?php echo $campaign[0]['Description'] ?>

				<?= view('categorias/campaign-cat'); ?>
					<br>
					<br>
					<?php
					if(session('type') != 2){ ?>
						<a href ="javascript:applyCampaign(<?php echo "'".base64_encode($campaign[0]['id'])."'"; ?>)" class="btn btn-outline-dark btn-lg px-5 py-3 fs-6 fw-bolder d-inline-flex p-2 bd-highlight">Aplicar</a>
					<?php } ?>
				</p>
			</div>
		</div>
		<?php elseif($campaign == 0): ?>

		<div class="selected-campaing card">
			<div class="card-header">
				<h5>No haz seleccionado ninguna campaña</h5>
			</div>
		</div>
		<?php endif; ?>