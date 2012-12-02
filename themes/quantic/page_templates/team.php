<section id="content">

	<?php $this->current_section = FALSE; ?>

	<h1 id="page-title"><?= $page->title ?></h1>

	<section id="page-intro">
		<?= $page->intro ?>
	</section>
	

	<section id="team">
	<?php foreach(fetch('squads') as $squad) : ?>
		<ul class="members">
			<?php foreach($squad->members as $member) : ?>
				<?php if($member): ?>
					<li class="member">
						<img src="<? echo $member->user->avatar_url; ?>" /> 
						<h2><?php echo $member->user->full_name() ?></h2>
						<p><?php echo $member->user->position ?></p>
						<p><?php if(!empty($member->user->twitter)) : ?><a href="http://www.twitter.com/<?php echo $member->user->twitter ?>" target="_blank" title="Follow <?php echo $member->user->full_name() ?> on Twitter @<?php echo $member->user->twitter ?>">@<?php echo $member->user->twitter ?></a><?php endif; ?></p>
					</li>
				<?php endif;?>
			<?php endforeach; ?>
		</ul>
	<?php endforeach; ?>
	</section>
	
	<section id="page-content">
		<?= $page->content ?>
		
		<h2>Current Vacancies</h2>	
		<ul>
		<?php foreach(fetch('articles', 'limit=10&section_id=4&status=published') as $vacancies) : ?>
			<li>
				<?= link_to($vacancies->title, article_url($vacancies->section->url_name, $vacancies->category->url_name, $vacancies->id, $vacancies->url_title)); ?>
			</li>
		<?php endforeach ; ?>
		</ul>
	</section>
	
	
	<?php sidebar('main'); ?>

</section>



<section id="blogs-announcements">
	<h2>Blogs & Announcements</h2>
	
	<?php foreach(fetch('articles', 'limit=4&section_id=1&status=published') as $blogs) : ?>
		<article>
			<img src="<?php echo $blogs->user->avatar_thumb_url ?>" title="Gavin Weeks - Managing Director" />
			<h3><?= link_to($blogs->title, article_url($blogs->section->url_name, $blogs->category->url_name, $blogs->id, $blogs->url_title)); ?></h3>
			<p class="meta">By <?php echo $blogs->user->full_name() ?> on <?php echo $blogs->created_at ?></p>
			<?php echo $blogs->short_content ?>
		</article>
	<?php endforeach ; ?>


</section>