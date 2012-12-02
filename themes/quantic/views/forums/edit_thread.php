<div id="content">
	<h1 id="page-title">Forums</h1>

	<?php echo partial('validation'); ?>
	<?php echo form_open(update_forum_thread_url(param('name'), param('id'), param('title'))); ?>
	<?php echo form_hidden('id', $thread->id); ?>
	<?php echo form_hidden('post_id', $post->id); ?>
	Title:<?php echo form_input('title', $thread->title); ?><br>
	<?php echo form_textarea('content', $post->content); ?><br>
	<?php echo form_submit('submit', 'Update Thread'); ?>
	</form>

</div>
