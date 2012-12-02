<div id="content" class="has-side">

<section id="article">
			<ul class="breadcrumb">
				<li><h2>User Posts</h2></li>
				<li><?= $post->category->name ?></li>
				<li class="here"><?= $post->title ?></li>
			</ul>
			<div id="the-post">
				<div id="post-meta">
					<span class="author-meta"><?= $post->created_at ?> by <a href="/profile/<?= $post->user->username ?>"><?= $post->user->full_name() ?></a></span> <?php widget('sharing'); ?>	
				</div>
				
				<h1 id="the-title"><?= $post->title ?></h1>
				
				
				
				<?php if (!empty($post->image_url)) :?>
					<img alt="<?php echo $post->title; ?>" src="<?php echo $post->image_url; ?>" class="rf-article-img">
				<?php endif; ?>
				
				<?= $post->content ?>
			
		</section>

<?= partial('comments', array(
	'model' => $post,
)) ?>

</div>
<?php sidebar('main'); ?>