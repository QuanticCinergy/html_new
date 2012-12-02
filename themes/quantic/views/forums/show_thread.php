<div id="content" class="forums">
	<h1 id="page-title">Forums</h1>

	<h2 class="topic"><span>Topic</span><?= $thread->title ?></h2>
	
	<div class="context-nav">
		<a class="generic_button float-left large mar-right-10 back" href="<?= forum_threads_url(param('name')) ?>/"><span>&lt;</span></a>	
		<a class="generic_button float-left large" href="#reply">New Reply</a>
		<?php if ( user_logged_in()) : ?>
			<?php if($thread->user_id == current_user()->id) : ?><span class="generic_button float-right large"><?= link_to('Edit Thread', edit_forum_thread_url(param('name'), param('id'), param('title'))) ?></span><?php endif; ?>
		<?php endif; ?>
	</div>
	
	<ul id="the-posts">
		<?php foreach($posts as $post) : ?>
		<li>
			<div class="post-author">
				<a href="<?= profile_url($post->user->username) ?>">
					<img src="<?= $post->user->avatar() ?>" />
				</a>
				
				<h3><?= link_to($post->user->username, profile_url($post->user->username)) ?></h3>
				<span class="name"><?= $post->user->full_name() ?></span>
				
			</div>
			<div class="the-post">
			<span class="meta"><?= $post->created_at ?></span>
			<p><?= $post->content ?></p>
			<ul class="edit-options">
			<?php if(current_user() && $post->user_id == current_user()->id) : ?>
				<li><a href="<?= edit_forum_post_url(param('name'), param('id'), param('title'), $post->id) ?>">Edit Post</a></li>
			<?php endif; ?>
               <?php if(current_user() && current_user()->group_id == 1) : ?>
	                <li class="adminedit"><?= link_to('Admin Edit', 'admin/forum_posts/edit/id/'.$post->id); ?></li>
				<?php endif; ?>
			</ul>
			</div>
		</li>
		<?php endforeach; ?>
	</ul>
	
	<div class="context-nav">
		<a class="generic_button float-left large mar-right-10 back" href="<?= forum_threads_url(param('name')) ?>/"><span>&lt;</span></a>	
		<a class="generic_button float-left large" href="#reply">New Reply</a>
		<?php if ( user_logged_in()) : ?>
			<?php if($thread->user_id == current_user()->id) : ?><span class="generic_button float-right large"><?= link_to('Edit Thread', edit_forum_thread_url(param('name'), param('id'), param('title'))) ?></span><?php endif; ?>
		<?php endif; ?>
	</div>
	
	
	<?= $pagination ?>
	
	<?php if (! user_logged_in()) : ?>
		<section id="new-post">
			<h4>Please <a href="/register">register</a> or <a href="/login">login</a> to post forum replies</h4>
		</section>
	<?php else: ?>

		<?php require FCPATH.'themes/quantic/views/forums/new_post.php'; ?>
	
	<?php endif; ?>

</div>
