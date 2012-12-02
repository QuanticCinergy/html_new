<div id="content" class="has-side videos horizontal-display">

	<ul class="breadcrumb">
		<li><h2>Videos Archive</h2></li>
		<li <?php if (!param('category')) : ?>class="here"<?php endif; ?>>Most Recent</li>
		<?php if (param('category')) : ?><li class="here"><?= humanize(param('category')); ?></li><?php endif; ?>
	</ul>

	<h1 id="page-title">Latest <?php if (param('category')) : ?><?= humanize(param('category')); ?><?php else : echo 'Videos'; ?><?php endif; ?></h1>

	<ul class="profile-tabs">
		<li><a href="/videos" class="current"><h2>Latest</h2></a></li>
	<?php foreach(fetch('video_categories') as $category) : ?>
		<li><a href="<?= site_url('videos/'. $category->url_name);?>"><h2><?= $category->name; ?></h2></a></li>
	<?php endforeach; ?>
	</ul>
	
	<section id="videos" class="a-list">
		<?php if(count($videos) > 0) : ?>
		<ul id="the-articles">
		<?php foreach($videos as $video) : ?>
			<li>
				<figure class="thumb-box">
					<span class="section-meta"><?= $video->category->url_name ?></span>
					<span class="thumb-crop"><a href="<?php echo video_url($video->category->url_name, $video->id, $video->url_title); ?>"><img alt="<?= $video->title ?>" src="<?= 'http://img.youtube.com/vi/'.$video->video_id.'/0.jpg'; ?>" class="rf-youtube-thumb"></a></span>
				</figure>
				<span class="meta">By <?= link_to($video->user->username, profile_url($video->user->username)) ?> // <?= $video->created_at ?></span>
				<h2><a href="<?= video_url($video->category->url_name, $video->id, $video->url_title); ?>"><?= $video->title ?></a></h2>
				
			</li>
		<?php endforeach; ?>
		</ul>
		<?php echo $pagination; ?>
		
		<?php else: ?>
			There are no videos in this area.
		<?php endif; ?>
	</section>


</div>
<?php sidebar('main')?>
