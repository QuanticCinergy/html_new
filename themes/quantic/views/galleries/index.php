<div class="has-side galleries" id="content">
<h1 id="page-title">Galleries</h1>

<ul class="section-list">
	<?php foreach($galleries as $gallery) : ?>
	<li>
		<div class="gallery-info">
			<h2><?= link_to($gallery->title, gallery_url($gallery->id, $gallery->url_title)) ?></h2>
			<span class="meta">By <?= link_to($gallery->user->username, profile_url($gallery->user->username)) ?> // <?= $gallery->created_at ?></span>
		</div>
		<ul class="preview-images">		
			<?php foreach($gallery->limit(6)->photos as $photo) : ?>
				<li><?= link_to(img($photo->photo_thumb_url), gallery_url($gallery->id, $gallery->url_title)) ?></li>
			<?php endforeach; ?>
		</ul>
	</li>
	<?php endforeach; ?>
</ul>

<?= $pagination ?>
</div>
<?php sidebar('main'); ?>
