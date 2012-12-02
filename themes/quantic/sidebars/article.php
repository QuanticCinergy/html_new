<aside id="sidebar" class="margin-top">	
	<?php if(count($related_articles) > 0): ?>
	<section id="related" class="list-box grad-bg">
		<h2>Related Articles</h2>

			<?php foreach($related_articles as $item): ?>
				<article>
					<img class="thumb" src="<?php echo $item->image_article_thumb_url ?>" title="<?php echo $item->title ?>" />
					<h3><a href="<?= article_url($item->section->url_name, $item->category->url_name, $item->id, $item->url_title) ?>"><?= $item->title ?></a></h3>
					<p class="meta name"><?php echo $item->username ?></p>
	    			<p class="meta"> <?= date("jS F Y", $item->created_at); ?></p>
				</article>
			<?php endforeach; ?>					

	</section>
	<?php endif; ?>
	
	
	<section id="news-feed" class="list-box grad-bg">
    		<h2>Latest News</h2><span class="all-link"><a href="/articles/news/">All News</a></span>
    		
    		
    		<?php foreach(fetch('articles', 'limit=3&section_id=3&status=published') as $news) : ?>
	    		<article>
	    			<img class="thumb" src="<?php echo $news->image_article_thumb_url ?>" title="<?php echo $news->title ?>" />
	    			<h3><?= link_to($news->title, article_url($news->section->url_name, $news->category->url_name, $news->id, $news->url_title)); ?></h3>
	    			<p class="meta name"><?php echo $news->user->full_name() ?></p>
	    			<p class="meta"><?php echo $news->created_at ?></p>
	    		</article>
			<?php endforeach ; ?>

    	
    	</section>
	<div class="fb_contain"><div class="fb-like-box" data-href="http://www.facebook.com/quanticgaming" data-width="298" data-height="290" data-show-faces="true" data-border-color="#DDD" data-stream="false" data-header="true"></div></div>
	
</aside>
