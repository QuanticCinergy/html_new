<h1><?php echo $article->title; ?></h1>

Author:<?php echo $article->user->first_name.' '.$article->user->last_name; ?><br>
Category:<?php echo $article->category->name; ?>
<p><?php echo $article->content; ?></p>

<h2>Comments:</h2>
<?php foreach($article->comments as $comment) : ?>
<br><b><?php echo $comment->user->first_name.' '.$comment->user->last_name; ?></b>
<p><?php echo $comment->content; ?></p>
<?php endforeach; ?>

<?php echo flash('validation'); ?>

<?php echo form_open('comments/create'); ?>
<?php echo form_hidden('resource', 'articles'); ?>
<?php echo form_hidden('resource_id', $article->id); ?>
<?php echo form_textarea('comment'); ?><br>
<?php echo form_submit('submit', 'Add Comment!'); ?>
</form>
