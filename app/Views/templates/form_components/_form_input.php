<div class="row mb-3">
	<label class="col-sm-2 col-form-label"><?= esc($label) ?></label>
	<div class="col-sm-10">
		<input
			type="<?= esc($type) ?>"
			class="form-control"
			name="<?= esc($name) ?>"
			placeholder="<?= esc($placeholder) ?>"
			value="<?= esc($value) ?>">
	</div>
</div>
