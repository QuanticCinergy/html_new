<div class="galleries" id="content">
<h1 id="page-title">Galleries</h1>

<p><?php echo $photo->description; ?></p>

Gallery: <?php echo link_to($photo->gallery->name, '/galleries/'.$photo->gallery->url_title); ?>

<?php echo img($photo->photo_thumb_url); ?>

Author:<?php echo link_to($photo->user->full_name(), 'profile/'.$photo->user->username); ?>

<?php echo partial('comments', array(
	'model' => $photo
)); ?>
</div>