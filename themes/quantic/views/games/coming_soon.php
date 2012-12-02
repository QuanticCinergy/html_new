<div id="content" class="has-side">

<section id="article">
			<ul class="breadcrumb">
				<li><h2>Games Database</h2></li>
				<li class="here">Coming Soon</li>
			</ul>
			
	<h1 id="page-title">Browse Games</h1>
	
	<ul class="profile-tabs">
		<li><a href="<?=site_url('games/recent');?>"><h2>Recently Released</h2></a></li>
		<li><a href="<?=site_url('games/coming_soon');?>" class="current"><h2>Coming Soon</h2></a></li>
		<li><a href="<?=site_url('games/genre');?>"><h2>Genres</h2></a></li>
		<li><a href="<?=site_url('games');?>"><h2>All</h2></a></li>
	</ul>
	
	<section id="games" class="a-list">
	
	<h3>Title <span>Release</span></h3>
	
		<?php if(count($games) > 0) : ?>
		<ul id="the-games">
		<?php foreach($games as $game) : ?>
			<li>
				<div class="title">
					<a href="<?= game_url($game->genre_url, $game->game_url) ?>">
						<?= $game->title ?>
					</a>
					<span>
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
					</span>
				</div>
			</li>
		<?php endforeach; ?>
		</ul>
		<?php echo $pagination; ?>
		
		<?php else: ?>
			There are no games in this area.
		<?php endif; ?>
	</section>
	

</div>

<?php sidebar('main'); ?>