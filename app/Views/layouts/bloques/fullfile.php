<div class="container ">
	<div class="col-md-12">
    <datalist id="suggestions">
		<?php
		foreach($fields as $field):
		?>
			<option id="option_field<?= $field['name_camp'] ?>" data-value="<?= $field['name_camp'] ?>" value="<?= $field['name_camp'] ?>"><?= $field['name_camp'] ?></option>
		<?php
		endforeach;
		?>
	</datalist>
	</div>
</div>