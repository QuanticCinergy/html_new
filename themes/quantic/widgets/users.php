<script>
	// perform JavaScript after the document is scriptable.
	$(function() {
	// setup ul.tabs to work as tabs for each div directly under div.panes
	$("ul.tabs").tabs("div.panes > div", {
		effect: 'fade'
	
	});
	}); 
</script>

<div class="widget sidewidget marg-10">
	<ul class="tabs">
		<li><a href="#"><h2>Latest Reviews</h2></a></li>
		<li><a href="#"><h2>Your Opinions</h2></a></li>
	</ul>

	<div class="panes">	
		<div class="pane">
			<ul class="section-list">
				<?php foreach(fetch('articles', 'limit=5&section_id=1&status=published') as $review) : ?>
				<li>
					<?php 
						if(strlen($review->image_article_thumb_url) > 0)
						{
							$img = $review->image_article_thumb_url;
						}
						else
						{
							// $img = site_url('themes/'.$name.'/assets/images/no-article.jpg');
							$img = site_url('themes/made2game/assets/images/no-article.jpg');
						}
					?>
					
					<?= link_to('<img title="'.$review->title.'" class="post-ico" src="'.$img.'">', article_url($review->section->url_name, $review->category->url_name, $review->id, $review->url_title)); ?>
					<h3><?= link_to($review->title, article_url($review->section->url_name, $review->category->url_name, $review->id, $review->url_title)); ?></h3>
					<span class="meta">By <?= link_to($review->user->username, profile_url($review->user->username)) ?> // <?= $review->created_at ?></span>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
		
		<div class="pane">
			<ul class="section-list">
				<?php foreach(fetch('comments', 'limit=5') as $item) : ?>
				<li>
					<?= link_to('<img title="'.$item->user->username.'" class="user-ico" src="'.$item->user->avatar().'">', profile_url($item->user->username)); ?>
					<h3><?= link_to($item->resource(), $item->resource_model()->resource_url()); ?></h3>
					<span class="meta">By <?= link_to($item->user->username, profile_url($item->user->username)) ?> // <?= $item->created_at ?></span>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>