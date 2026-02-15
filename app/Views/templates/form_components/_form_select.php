<div class="row mb-4">
	<label class="col-sm-2 col-form-label"><?= esc($label) ?></label>
	<div class="col-sm-10">
		<select class="form-select" name="<?= esc($name) ?>" <?= !empty($multiple) ? 'multiple' : '' ?>>
			<?php if (!empty($placeholder)): ?>
				<option value=""><?= esc($placeholder) ?></option>
			<?php endif; ?>
			<?php foreach ($options as $option): ?>
				<option value="<?= esc($option['value']) ?>" <?= !empty($selected) && (is_array($selected) ? in_array($option['value'], $selected) : $selected == $option['value']) ? 'selected' : '' ?>>
					<?= esc($option['label']) ?>
				</option>
			<?php endforeach; ?>
		</select>
	</div>
</div>
