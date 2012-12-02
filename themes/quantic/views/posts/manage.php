<div id="content" class="has-side articles">
	
	<ul class="breadcrumb">
		<li><h2>Your Posts</h2></li>
		<li class="here">Manage</li>
	</ul>
			
	<h1 id="page-title">Your shared posts</h1>
	

    <span class="generic_button float-left"><a href="/profile/posts/add/">New Post</a></span>
	<?php if(count($posts) > 0) : ?>
	<ul id="manage-list">
	<?php foreach($posts as $post) : ?>
		<li>
			<h2><a href="/profile/posts/<?= $post->id; ?>/edit/"><?= $post->title ?></a></h2>
			<span class="meta">
            <a href="/profile/posts/<?= $post->id; ?>/edit/">Edit Post</a>
            <a href="/profile/posts/<?= $post->id; ?>/remove/">Remove Post</a> 
			<?php if ($post->is_approved == 1) : ?>This post has been approved<?php else : ?>This post is awaiting approval<?php endif; ?>
            </span>
		</li>
	<?php endforeach; ?>
	</ul>
	<?php echo $pagination; ?>
	
	<?php else: ?>
		You have no submitted posts.
	<?php endif; ?>
	
	

</div>

<?php sidebar('main'); ?>