<div id="content">
	<h1 id="page-title">Forums</h1>

	<?php echo partial('validation'); ?>
	<?php echo form_open(update_forum_post_url(param('name'), param('id'), param('title'), param('post_id'))); ?>
	<?php echo form_textarea('content', $post->content); ?><br>
	<?php echo form_submit('submit', 'Update Post', 'class=generic_button'); ?>
	</form>

</div>
