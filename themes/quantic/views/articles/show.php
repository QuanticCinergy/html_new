<?php spotlight('sponsors'); ?>

<div id="content" class="has-side margin-top">
	<!--<h2 id="page-title"><?= $article->section->name ?></h2>	-->

	<article id="article">
		<div id="the-post">			
			<h1 id="the-title"><?= $article->title ?></h1>
			<p class="meta">Posted by <?= $article->user->full_name() ?> on <?= $article->created_at ?></p>				
			<?php if(isset($categories) && count($categories) > 0): ?>
			<ul class="categories">
				<li class="first">Categories:</li>
				<?php foreach($categories as $cat): ?>
					<li><?=$cat;?></li>
				<?php endforeach; ?>	
			</ul>
			<?php endif; ?>
	
			
			
			<?php if (!empty($article->image_article_url)) :?>
				<img alt="<?php echo $article->title; ?>" title="<?php echo $article->title; ?>" src="<?php echo $article->image_article_url; ?>" class="rf-article-img">
			<?php endif; ?>
			
			<?= $article->content ?>
			
						<div id="article-tweet"><a href="https://twitter.com/share" class="twitter-share-button" data-via="QuanticGaming">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></div>
<div id="article-fb"><div class="fb-like" data-send="false" data-layout="button_count" data-width="30" data-show-faces="false"></div></div>
			<?php if($article->photos) : ?>
			<div class="gallery-scroller">
				<a class="prev browse left">PREV</a>
				<div class="gallery-items">
					<ul class="items">
						<?php foreach($article->photos as $photo) : ?>
							<li><a rel="example_group" href="<?= $photo->photo_url; ?>"><img id="<?= $photo->id ?>" src="<?= $photo->photo_thumb_url ?>" /></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<a class="next browse right">NEXT</a>
			</div>
			<?php endif; ?>
		</div>		
	
		
				
	</article> 
	
	
</div>
	
<?php sidebar('article');?>
