<h1>Edit Photo</h1>
<?php echo partial('validation'); ?>
<?php echo form_open_multipart('admin/photos/update'); ?>
<?php echo form_hidden('id', param('id')); ?>
<h3>Title:</h3>
<?php echo form_input('title', $photo->title); ?><br>
<h3>Gallery:</h3>
<?php echo form_dropdown('gallery_id', $galleries, $photo->gallery_id); ?><br>
<h3>Description:</h3>
<?php echo form_textarea('description', $photo->description, 'class="short"'); ?><br>
<h3>Photo:</h3>
<?php echo img($photo->photo_thumb_url); ?> <br /><br />
<?php echo form_upload('photo'); ?><br>
<?php echo form_submit('submit', 'Update'); ?>
</form>

