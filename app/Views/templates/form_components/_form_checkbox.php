<div class="row mb-3">
	<label class="col-sm-2 col-form-label">&nbsp;</label>
	<div class="col-sm-10 d-flex align-items-center">
		<input type="checkbox" class="form-check-input me-2" name="<?= esc($name) ?>" id="<?= esc($name) ?>" <?= !empty($checked) ? 'checked' : '' ?>>
		<label for="<?= esc($name) ?>" class="form-check-label mb-0"><?= esc($label) ?></label>
	</div>
</div>
