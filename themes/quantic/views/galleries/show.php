<script>
	$(function() {
	
		$(".gallery-items").scrollable();
	
		$(".items img").click(function() {
	
		// see if same thumb is being clicked
		if ($(this).hasClass("active")) { return; }
	
		// calclulate large image's URL based on the thumbnail URL (flickr specific)
		var url = $(this).attr("src").replace("_thumb", "");
	
		// get handle to element that wraps the image and make it semi-transparent
		var wrap = $("#image_wrap").fadeTo("medium", 0.5);
	
		// the large image from www.flickr.com
		var img = new Image();
	
	
		// call this function after it's loaded
		img.onload = function() {
	
			// make wrapper fully visible
			wrap.fadeTo("fast", 1);
	
			// change the image
			wrap.find("img").attr("src", url);
	
		};
	
		// begin loading the image from www.flickr.com
		img.src = url;
	
		// activate item
		$(".items img").removeClass("active");
		$(this).addClass("active");
	
		// when page loads simulate a "click" on the first image
		}).filter(":first").click(); 

	});

</script>


<div class="galleries" id="content">
<h1 id="page-title"><?= $gallery->title ?> <span class="how-many"><?= $gallery->count('photos') ?> pics</span></h1>

<div id="the-gallery">

	
	<div id="the-image">
		<div id="image_wrap">
			<img src="http://static.flowplayer.org/tools/img/blank.gif" />
		</div>
	</div>
	
	<div class="gallery-scroller">
		<a class="prev browse left">PREV</a>
		<div class="gallery-items">
			<ul class="items">
				<?php foreach($gallery->photos as $photo) : ?>
					<li><img id="<?= $photo->id ?>" src="<?= $photo->photo_thumb_url ?>" /></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<a class="next browse right">NEXT</a>
	</div>
	
	<span class="meta">Posted <?= $gallery->created_at ?></span>
	
	<?php widget('sharing'); ?>
	
	<?= $gallery->description ?>
	
</div>



<?= partial('comments', array(
	'model' => $gallery
)) ?>

</div>

