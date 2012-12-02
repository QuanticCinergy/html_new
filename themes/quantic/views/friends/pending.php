<div id="content" class="has-side notifications">
<h1 id="page-title">Requests</h1>
<ul class="section-list">
<?php foreach($friends as $friend) : ?>
	<li>
		<img src="<?= $friend->avatar() ?>" class="avatar" />
		<h2><?= link_to($friend->username, profile_url($friend->username)) ?></a></h2>
		<h3><?= $friend->full_name() ?></h3>
		
		<div class="the-buttons">
			<a href="<?= accept_friend_url($friend->id) ?>" class="generic_button float-right">Accept</a>
			<a href="<?= deny_friend_url($friend->id) ?>" class="generic_button float-right">Decline</a>
		</div>
	</li>
<?php endforeach; ?>
</ul>
</div>

<?php sidebar('main');?>
