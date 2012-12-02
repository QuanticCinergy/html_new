<section id="content">

	<?php $this->current_section = FALSE; ?>

<h1 id="page-title"><?= $page->title ?></h1>

<section id="page-intro">
	<?= $page->intro ?>
</section>

<section id="page-content">
	<?= $page->content ?> 
</section>
<?php sidebar('main'); ?>


</section>