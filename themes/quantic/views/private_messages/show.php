<div id="content" class="has-side">
	<h1><?php echo $message->subject; ?></h1>
	From: <?php echo link_to($message->sender->full_name(), 'profile/'.$message->sender->username); ?><br>
	To: <?php echo link_to($message->receiver->full_name(), 'profile/'.$message->receiver->username); ?>
	<p><?php echo $message->content; ?></p>
	<a href="/profile/messages/new/id/<?php echo $message->sender->id; ?>/reply/<?php echo $message->id; ?>/" class="generic_button">Reply</a>
</div>
<?php sidebar('main'); ?>