<div id="content" class="has-side messaging">
<h1 id="page-title"><?= $folder ?></h1>

<?= link_to('New Message', new_message_url(), '.generic_button') ?>

<ul class="section-list">
<?php foreach($messages as $message) : ?>
	<li>
		<img src="<?= $message->sender->avatar() ?>" class="avatar" />
		<div class="from">
			<h3><?= link_to($message->sender->full_name(), profile_url($message->sender->username)) ?></h3>
			<span class="meta"><?= $message->created_at ?></span>
		</div>
		
		<div class="msg-info">
			<h2><?= link_to($message->subject, message_url($message->id)) ?></h2>
			<p><?= substr($message->content, 0, 50) ?></p>
		</div>
	</li>
<?php endforeach; ?>
</ul>

<?= $pagination ?>

</div>

<?php sidebar('main'); ?>
