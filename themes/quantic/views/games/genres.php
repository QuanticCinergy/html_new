<div id="content" class="has-side">

<section id="article">
			<ul class="breadcrumb">
				<li><h2>Games Database</h2></li>
				<li>Genres</li>
				<li class="here"><?= humanize(param('genre')) ?></li>
			</ul>
			
	<h1 id="page-title">Browse Games</h1>
	
	<ul class="profile-tabs">
		<li><a href="<?=site_url('games/recent');?>"><h2>Recently Released</h2></a></li>
		<li><a href="<?=site_url('games/coming_soon');?>"><h2>Coming Soon</h2></a></li>
		<li><a href="<?=site_url('games/genre');?>" class="current"><h2>Genres</h2></a></li>
		<li><a href="<?=site_url('games');?>"><h2>All</h2></a></li>
	</ul>
	
	<section id="games" class="a-list">
	
	<h3>Genre</h3>
	
		<?php if(count($genres) > 0) : ?>
		<ul id="the-games">
		<?php foreach($genres as $genre) : ?>
			<li>
				<div class="title">
					<a href="<?= site_url('games/genre/'.$genre->url_name); ?>">
						<?= $genre->name ?>
					</a>
				</div>
			</li>
		<?php endforeach; ?>
		</ul>
		
		<?php else: ?>
			There are currently no genres.
		<?php endif; ?>
	</section>
	

</div>

<?php sidebar('main'); ?>