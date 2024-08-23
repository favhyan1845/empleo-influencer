<?php
if($campaign != 0 ): ?>
	<div class="selected-campaing d-grid gap-3 card">
		<div class="card-body">
			<h5>Se ha aplicado a la campaña</h5>
		</div>
	</div>
	<?php elseif($campaign == 0): ?>

	<div class="selected-campaing card">
		<div class="card-header">
			<h5>No haz seleccionado ninguna campaña</h5>
		</div>
	</div>
<?php endif; ?>