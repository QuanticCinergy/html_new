<div class="has-side" id="content">

<h1 id="page-title">My Friends</h1>

<ul id="my-friends">
<?php foreach($friends as $friend) : ?>
<li>
	<img class="avatar" src="<?= $friend->avatar() ?>" width="100" height="100" />
	<h3><?= link_to($friend->username, profile_url($friend->username)) ?><a href="<?= delete_friend_url($friend->id) ?>" class="generic_button float-right">Delete Friend</a></h3>
	<h4><?= $friend->full_name() ?></h4>
	<p><?php echo $friend->about ?></p>
</li>
<?php endforeach; ?>
</ul>

<?= $pagination ?>

</div>

<?php sidebar('main'); ?>
