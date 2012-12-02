<div id="content" class="has-side articles">
	
	<h1 id="page-title">Your submitted articles
    <span style="text-align:right;font-size:11px;font-weight:500;float:right;margin-right:15px;">
    <a href="/profile/posts/unpublished/">You have 0 unpublished posts</a>
    </span></h1>
	

    <span class="generic_button float-left"><a href="/profile/posts/add/">Post new article</a></span>
	<?php if(count($articles) > 0) : ?>
	<ul id="manage-list">
	<?php foreach($articles as $article) : ?>
		<li>
			<h2><a href="<?= article_url($article->section->url_name, $article->category->url_name, $article->id, $article->url_title) ?>"><?= $article->title ?></a></h2>
			<span class="meta">
            <a href="/profile/posts/<?= $article->id; ?>/edit/">Edit Article</a>
            <a href="/profile/posts/<?= $article->id; ?>/remove/">Remove Article</a> 
			<?php if ($article->status == 'draft') : ?><a href="/profile/posts/<?= $article->id; ?>/submit/">Submit Article For Approval</a><?php endif; ?>
            </span>
		</li>
	<?php endforeach; ?>
	</ul>
	<?php echo $pagination; ?>
	
	<?php else: ?>
		There are no articles in this area.
	<?php endif; ?>
	
	

</div>

<?php sidebar('main'); ?>