<div class="d-flex gap-2">
	<button type="submit" class="btn btn-success">
		<?= esc($submitLabel ?? 'Speichern') ?>
	</button>
	<a href="<?= esc($cancelUrl) ?>" class="btn btn-secondary">
		<?= esc($cancelLabel ?? 'Abbrechen') ?>
	</a>
</div>
