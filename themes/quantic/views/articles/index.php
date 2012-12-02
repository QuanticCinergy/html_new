<?php spotlight('sponsors'); ?>

<div id="content" class="has-side articles horizontal-display margin-top">

			
	<h1 id="page-title">Browse Articles</h1>

	
	<section id="articles" class="a-list">
		<?php if(count($articles) > 0) : ?>
		<ul id="the-articles">
		<?php foreach($articles as $article) : ?>
			<li>
				<figure class="thumb-box">
					<span class="thumb-crop"><a href="<?= article_url($article->section->url_name, $article->category->url_name, $article->id, $article->url_title) ?>">
						<?php 
						if(strlen($article->image_article_thumb_url) > 0)
						{
							$img = $article->image_article_thumb_url;
						}
						else
						{
							// $img = site_url('themes/'.$name.'/assets/images/no-article.jpg');
							$img = site_url('themes/made2game/assets/images/no-article.jpg');
						}
						?>
						<img alt="<?= $article->title ?>" src="<?= $img; ?>" class="rf-thumb" />
					</a></span>
				</figure>
				<h2><a href="<?= article_url($article->section->url_name, $article->category->url_name, $article->id, $article->url_title) ?>"><?= $article->title ?></a></h2>
				<span class="meta">By <?= link_to($article->user->username, profile_url($article->user->username)) ?> // <?= $article->created_at ?> <?php if (! param('section')) : ?>// <span class="section-meta <?= $article->section->url_name; ?>"><?= $article->section->url_name ?></span><?php endif; ?></span>
				
				<?= character_limiter($article->short_content, 230); ?>
			</li>
		<?php endforeach; ?>
		</ul>
		<?php echo $pagination; ?>
		
		<?php else: ?>
			There are no articles in this area.
		<?php endif; ?>
	</section>
	
	<div id="mpu-01" class="mpu marg-20">
		<?php foreach(ads('mpugoogle') as $ad) : ?>
		<?php echo $ad->embed_code ? $ad->embed_code : link_to(img($ad->image_article_thumb_url), $ad->url); ?>
		<?php endforeach; ?>
	</div>
	

</div>

<?php sidebar('main'); ?>

