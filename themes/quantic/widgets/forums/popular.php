<div class="sidewidget">
	<h2>Popular Threads</h2>
	<ul class="section-list marg-20">
		<?php foreach(fetch('forum_threads', 'limit=5&order_by_desc=forum_posts_number') as $thread) : ?>
		<li>
			<img class="user-ico" src="<?= $thread->user->avatar() ?>" />
			<h3><a href="#"><?= link_to($thread->title, forum_thread_url($thread->forum->url_name, $thread->id, $thread->url_title)) ?></a></h3>
			<span class="meta">by <?= link_to($thread->user->username, profile_url($thread->user->username)) ?></span>
			
		</li>
        <?php endforeach; ?>
	</ul>
</div>