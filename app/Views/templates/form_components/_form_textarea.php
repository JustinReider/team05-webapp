<div class="row mb-3">
	<label class="col-sm-2 col-form-label"><?= esc($label) ?></label>
	<div class="col-sm-10">
		<textarea
			class="form-control"
			name="<?= esc($name) ?>"
			rows="<?= esc($rows ?? 4) ?>"
			placeholder="<?= esc($placeholder) ?>"><?= esc($value) ?></textarea>
	</div>
</div>
