<section id="comments">
	<header>
		<h2>Opinion</h2>
	</header>
	
	<?php echo $pagination; ?>
	<ul id="the-comments">
    
		<?php foreach($comments as $comment) : ?>
		<li>
			<div class="comment-author">		
				<a href="/profile/<?php echo $comment->user->username; ?>">
					<img src="<?php echo $comment->user->avatar(); ?>" />
				</a>
			</div>
			<div class="the-comment">
				<div class="user-info">
				
					<ul class="edit-options">
						<?php if(current_user() && current_user()->group_id == 1) : ?>
							<li><?= link_to('Admin Edit', 'admin/comments/edit/id/'.$comment->id); ?></li>
						<?php endif; ?>
						
						<?php if ( user_logged_in()) : ?>
							<?php if(current_user() && $comment->user_id == current_user()->id) : ?>
							<li><a href="<?= edit_comment_url($comment->id) ?>">Edit Post</a></li>
							<?php endif; ?>
						<?php endif; ?>
					</ul>
				
					<h3><?php echo link_to($comment->user->username, 'profile/'.$comment->user->username); ?></h3>
					<span class="meta"><?php echo $comment->created_at; ?></span>
					
				</div>
				<p><?php echo $comment->content; ?></p>
				</div>
		</li>
		<?php endforeach; ?>
	</ul>
    <?php echo $pagination; ?>	
	
	<?php if (! user_logged_in()) : ?>
		<div id="comment-form">
			<h4>Please <a href="/register">register</a> or <a href="/login">login</a> to post comments</h4>
		</div>
	<?php else: ?>
		
		<div id="comment-form">
			
			<div id="user-info">
				<?php echo img(current_user()->avatar()); ?>
			</div>
			
			<div id="write-comment">
				<?php echo form_open('comments/create'); ?>
				<?php echo form_hidden('resource', plural(get_class($model))); ?>
				<?php echo form_hidden('resource_id', $model->id); ?>
				<?php echo form_textarea('comment'); ?><br>
				<span class="generic_surround"><?php echo form_submit('submit', 'Add Comment'); ?></span>
				</form>
			</div>
		</div>
	<?php endif; ?>
	
	<?php echo partial('validation'); ?>
	
</section>
