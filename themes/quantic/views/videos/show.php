<div id="content" class="has-side">

<section id="video">
			<ul class="breadcrumb">
				<li><h2>Videos</h2></li>
				<li><?= $video->category->name ?></li>
				<li class="here"><?= $video->title ?></li>
			</ul>
			<div id="the-post">
				<div id="post-meta">
					<span class="author-meta"><?= $video->created_at ?> by <a href="/profile/<?= $video->user->username ?>"><?= $video->user->full_name() ?></a></span> <?php widget('sharing'); ?>	
				</div>
				
				<h1 id="the-title"><?= $video->title ?></h1>
				
				
				
				<?php echo $video->embed_code; ?>
				
				<?php if(count($games) > 0): ?>
				<div class="categoires-list" style="margin-top:20px;">
					<ul>
						<li class="first">Related Games</li>
						<?php foreach($games as $game): ?>
							<li><a href="<?= $game['url']; ?>"><?= $game['title']; ?></a></li>
						<?php endforeach; ?>					
					</ul>
				</div>
				<? endif; ?>
				
			
		</section>

<?= partial('comments', array(
	'model' => $video,
)) ?>

</div>
<?php sidebar('main'); ?>