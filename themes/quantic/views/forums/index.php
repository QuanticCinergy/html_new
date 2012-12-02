<div id="content" class="forums has-side">
	<h1 id="page-title">Forums</h1>

	<ul id="forum-list">
		<?php foreach($sections as $section) : ?>
		<li><h2><?= $section->name ?> <span class="threads">Threads</span></h2>
			<ul class="the-forums">
				<?php foreach($section->forums as $forum) : ?>
					<li>
						<img src="<?= $forum->icon_thumb_url ?>" width="64" height="64" class="thumb-left" />
						<h3><?= link_to($forum->name, forum_threads_url($forum->url_name)) ?></h3>
						<?= $forum->description ?>
						<?php
							$thread = $forum->latest_thread();
							if($thread) {
								echo link_to($thread->title, forum_thread_url($forum->url_name, $thread->id, $thread->url_title));
							}
						?>
						<span class="forum-threads">
							<?php echo $forum->count('forum_threads'); ?>
							
						</span>
					</li>
				<?php endforeach; ?>
			</ul>
		</li>
		<?php endforeach; ?>
	</ul>
</div>
