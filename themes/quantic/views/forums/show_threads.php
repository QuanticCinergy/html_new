<div id="content" class="forums">
	<h1 id="page-title">Forums</h1>

	<h2 id="section-title"><?= fetch_one('forums', 'url_name='.param('name'))->name ?></h2>

	<div class="context-nav">
		<a class="generic_button float-left large mar-right-10 back" href="<?= forums_url() ?>"><span>&lt;</span>	</a>
		<?php if (user_logged_in()) : ?>
			<span class="generic_button float-left large"><?= link_to('New Thread', new_forum_thread_url(param('name'))) ?></span>
		<?php else: ?>
			<span class="generic_button float-left large"><a href="<?= login_url() ?>">New Thread</a></span>
		<?php endif; ?>
	</div>
	
	<table class="forum-table" width="100%">
		<tr>
			<th width="70"></th>
			<th width="700">Thread</th>
			<th width="60" class="replies">Replies</th>
			<th>Author</th>
		</tr>
	<?php foreach($threads as $thread) : ?>
		<tr>
			<td align="center"><img src="/themes/dignitas/assets/images/forum/env_on.png" /></td>
			<td><?= link_to($thread->title, forum_thread_url(param('name'), $thread->id, $thread->url_title)) ?></td>
			<td class="replies"><?= $thread->count('posts') ?></td>
			<td><?= link_to($thread->user->username, profile_url($thread->user->username)) ?></td>
		</tr>
	<?php endforeach; ?>
	</table>
	
	<?= $pagination ?>

</div>
