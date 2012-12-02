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
		<li><a href="#"><h2>Latest News</h2></a></li>
		<li><a href="#"><h2>Latest Videos</h2></a></li>
	</ul>

	<div class="panes">
		<div class="pane">
			<ul class="section-list">
				<?php foreach(fetch('articles', 'limit=5&section_id=3&status=published') as $news) : ?>
				<li>
					<?php 
						if(strlen($news->image_article_thumb_url) > 0)
						{
							$img = $news->image_article_thumb_url;
						}
						else
						{
							// $img = site_url('themes/'.$name.'/assets/images/no-article.jpg');
							$img = site_url('themes/made2game/assets/images/no-article.jpg');
						}
					?>
				
					<?= link_to('<img title="'.$news->title.'" class="post-ico" src="'.$img.'">', article_url($news->section->url_name, $news->category->url_name, $news->id, $news->url_title)); ?>
					<h3><?= link_to($news->title, article_url($news->section->url_name, $news->category->url_name, $news->id, $news->url_title)); ?></h3>
					<span class="meta">By <?= link_to($news->user->username, profile_url($news->user->username)) ?> // <?= $news->created_at ?></span>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
		
		<div class="pane">
			<ul class="section-list">
				<?php foreach(fetch('videos', 'limit=5') as $item) : ?>
				<li>
					<?= link_to('<img title="'.$item->title.'" class="post-ico" src="http://img.youtube.com/vi/'.$item->video_id.'/1.jpg">', video_url($item->category->url_name, $item->id, $item->url_title)); ?>
					<h3><?= link_to($item->title, video_url($item->category->url_name, $item->id, $item->url_title)); ?></h3>
					<span class="meta">By <?= link_to($item->user->username, profile_url($item->user->username)) ?> // <?= $item->created_at ?></span>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>