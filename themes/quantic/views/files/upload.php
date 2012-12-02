<?php partial('validation_errors'); ?>
<?php echo form_open_multipart('files/create'); ?>
Name:<?php echo form_input('name'); ?><br>
Description:<br><?php echo form_textarea('description'); ?><br>
Category:<?php echo form_dropdown('category_id', $categories); ?><br>
File:<?php echo form_upload('file'); ?>
<br><?php echo form_submit('submit', 'Upload'); ?>
</form>
