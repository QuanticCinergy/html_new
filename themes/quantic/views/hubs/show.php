<!-- Stylesheet -->
<style type="text/css" media="screen">
	<?= $hub_css; ?>
</style>

<div class="has-side" id="content">
	
	<?= $hub->content; ?>
		
	<div id="home-content" class="hub-items horizontal-display">
		<section id="latest-news" class="a-list">
		<h2 style="line-height:40px;">Latest Articles</h2>
			<ul>
				<?php foreach($articles as $article) : ?>
				<li>
					<div class="thumb-box <?= $article['section']; ?>-thumb">
						<span class="section-meta <?= $article['section']; ?>"><?= singular($article['section']); ?></span>
						<span class="thumb-crop"><?= link_to('<img alt="'.$article['title'].'" src="'.$article['image_thumb_url'].'" class="rf-thumb">', $article['url']) ?></span>
					</div>
					
					<span class="meta">By <?= link_to($article['username'], profile_url($article['username'])); ?> // <?= $article['created_at'] ?></span>
					<h3><?= link_to($article['title'], $article['url']) ?></h3>
					<?= $article['short_content'] ?>
				</li>
				<?php endforeach; ?>
			</ul>
		</section>
		
		<section id="latest-videos" class="a-list">
		<h2 style="line-height:40px;">Latest Videos</h2>
			<ul>
				<?php foreach($videos as $video) : ?>
					<li>
						<figure class="thumb-box">
							<span class="section-meta"><?= $video['category'] ?></span>
							<span class="thumb-crop"><a href="<?= video_url($video['category'], $video['id'], $video['url_title']); ?>"><img alt="<?= $video['title'] ?>" src="<?= 'http://img.youtube.com/vi/'.$video['video_id'].'/0.jpg'; ?>" class="rf-youtube-thumb"></a></span>
						</figure>
						<span class="meta">By <?= link_to($video['username'], profile_url($video['username'])) ?> // <?= $video['created_at']; ?></span>
						<h3><a href="<?= video_url($video['category'], $video['id'], $video['url_title']); ?>"><?= $video['title']; ?></a></h3>
						
					</li>
				<?php endforeach; ?>
			</ul>
		</section>
	</div>
		

				
	</div>
<?php sidebar('main'); ?>