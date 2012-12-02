<div id="content">
<?php echo form_open($data['action']); ?>
<?php foreach($data['fields'] as $field=>$value) {
	echo form_hidden($field, $value);
} ?>
<?php echo form_submit('submit', 'Pay'); ?>
</form>
</div>
