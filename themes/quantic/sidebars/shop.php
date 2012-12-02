<div id="sidebar">
	
	<?php widget('shop/basket'); ?>
	
	<?php widget('shop/categories'); ?>
	
<div id="mpu-01" class="mpu marg-10">
		<?php foreach(ads('mputop') as $ad) : ?>
		<?php echo $ad->embed_code ? $ad->embed_code : link_to(img($ad->image_thumb_url), $ad->url); ?>
		<?php endforeach; ?>
	</div>
</div>
