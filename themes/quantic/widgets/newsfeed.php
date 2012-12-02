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