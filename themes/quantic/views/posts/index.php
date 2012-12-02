<div id="content" class="has-side articles horizontal-display">

<h1 id="page-title">Latest User Posts</h1>


	<section id="articles" class="a-list">
		<?php if(count($posts) > 0) : ?>
		<ul id="the-articles">
		<?php foreach($posts as $post) : ?>
			<li>
				<figure class="thumb-box">
					<?php if (! param('category')) : ?><span class="section-meta <?= $post->category->url_name; ?>"><?= $post->category->url_name ?></span><?php endif; ?>
					<span class="thumb-crop"><a href="<?= post_url($post->category->url_name, $post->id, $post->url_title) ?>"><img alt="<?= $post->title ?>" src="<?= $post->image_url ?>" class="rf-thumb"></a></span>
				</figure>
				<span class="meta">By <?= link_to($post->user->username, profile_url($post->user->username)) ?> // <?= $post->created_at ?></span>
				<h2><a href="<?= post_url($post->category->url_name, $post->id, $post->url_title) ?>"><?= $post->title ?></a></h2>
				
				<?= $post->short_content ?>
			</li>
		<?php endforeach; ?>
		</ul>
		<?php echo $pagination; ?>
		
		<?php else: ?>
			There are no posts in this area.
		<?php endif; ?>
	</section>
	

</div>

<?php sidebar('main'); ?>
