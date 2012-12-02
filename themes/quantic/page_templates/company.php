<section id="content">

	<?php $this->current_section = FALSE; ?>

<h1 id="page-title"><?= $page->title ?></h1>

<section id="page-intro">
	<?= $page->intro ?>
</section>

<?php widget('big-four');?>

<section id="page-content">
	<?= $page->content ?> 
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