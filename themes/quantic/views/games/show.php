<script>
	// perform JavaScript after the document is scriptable.
	$(function() {
	// setup ul.tabs to work as tabs for each div directly under div.panes
	$("ul.profile-tabs").tabs("div.sections > div", {
		effect: 'fade',
	
	});
	}); 
</script>

<div id="content" class="has-side">

<section id="article">
	<section id="user-header">
	
	<ul class="breadcrumb">
		<li><h2>Games Database</h2></li>
		<li><?= $game->genre->name; ?></li>
		<li class="here"><?= $game->title; ?></li>
	</ul>
	
	
	<div class="my-avatar"><?php if(!img($game->image)) : ?><img src="/themes/made2game/assets/images/noboxart.png" /><?php else : ?><?= img('/uploads/games/'.$game->image); ?><?php endif; ?></div>
	<h1 id="page-title"><?php echo $game->title; ?></h1>
	
	<ul id="meta">
		<li>Developer: <span><?= $game->developer; ?></span></li>
		<li>Publisher: <span><?= $game->publisher; ?></span></li>
		<?php if($game->release) : ?><li>Release Date: <span>
		
		<?php
						
						$release = $game->release;
						$unsure  = $game->unsure_of_date;
						
						$day   = (int)date("d", $release);
						$month = (int)date("m", $release);
						$year  = (int)date("Y", $release);
						
						// When we scrapped dates they were all in differetn formats
						// some dates didnt include everything, eg, day, month.
						// So the flag unsure_of_date states this
						
						if($day > 1 AND $month > 1)
						{
							$release_str = sprintf("%s/%s/%s", date("d", $release), 
															   date("m", $release), 
															   date("Y", $release));
						}
						elseif($month > 1)
						{
							$release_str = sprintf("%s/%s", date("m", $release), date("Y", $release));
						}
						else
						{
							$release_str = date("Y", $release);
						}
						
						?>
						<?= $release_str; ?>
						</span></li><?php endif;?>
	</ul>
	
	<div class="status"><?= $game->description; ?></div>
	
	</section>
	
	<div id="home-content">
	
		<ul class="profile-tabs">
			<li><a href="#"><h2>Latest Articles</h2></a></li>
			<li><a href="#"><h2>Related Games</h2></a></li>
		</ul>
		
		<div class="sections">	
		<div class="pane">
		
		<div class="horizontal-display">
		<section id="articles" class="a-list">
		
		<ul id="the-articles">
		<?php if(count($articles) > 0) : ?>
		<?php foreach($articles as $article) : ?>
			<li>
				<figure class="thumb-box <?= $article['section']; ?>-thumb">
					<span class="section-meta <?= $article['section']; ?>"><?= $article['section']; ?></span>
					<span class="thumb-crop"><a href="<?= $article['url']; ?>"><img alt="<?= $article['title'] ?>" src="<?= $article['image_url'] ?>" class="rf-thumb"></a></span>
				</figure>
				<span class="meta">By <?= link_to($article['username'], profile_url($article['username'])) ?> // <?= $article['created_at'] ?></span>
				<h2><a href="<?= $article['url']; ?>"><?= $article['title']; ?></a></h2>
				
				<?= $article['short_content']; ?>
			</li>
		<?php endforeach; ?>
		<?php else : ?>
			<li class="none">There are no articles for this game.</li>
		</ul>
		<?php endif; ?>
		
		</section>
		</div>
		</div>
		
		<div class="pane">
		
		<section id="games" class="a-list">
			<h3>Title <span>Release</span></h3>
			
			<ul id="the-games">
			<?php foreach(fetch('games', 'limit=8&genre_id='.$game->genre->id) as $related) : ?>
				<li>
				<div class="title">
					<a href="<?= game_url($related->genre->url_name, $related->url_title) ?>">
						<?= $related->title ?>
					</a>
					<span>
						<?php
						
						$release = $related->release;
						$unsure  = $related->unsure_of_date;
						
						$day   = (int)date("d", $release);
						$month = (int)date("m", $release);
						$year  = (int)date("Y", $release);
						
						// When we scrapped dates they were all in differetn formats
						// some dates didnt include everything, eg, day, month.
						// So the flag unsure_of_date states this
						
						if($day > 1 AND $month > 1)
						{
							$release_str = sprintf("%s/%s/%s", date("d", $release), 
															   date("m", $release), 
															   date("Y", $release));
						}
						elseif($month > 1)
						{
							$release_str = sprintf("%s/%s", date("m", $release), date("Y", $release));
						}
						else
						{
							$release_str = date("Y", $release);
						}
						
						?>
						<?= $release_str; ?>
					</span>
				</div>
			</li>
			<?php endforeach; ?>
		</section>
		
		</div>
		
		</div>
		
	</div>
	

</div>

<?php sidebar('main'); ?>