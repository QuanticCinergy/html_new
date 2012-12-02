<div id="lead-block">
	<ul>
	<?php foreach($spotlight->items as $item) : ?>
		<li>
			<a href="<?php echo $item->url; ?>"><img src="<?php echo $item->image_url; ?>" width="243" height="193" /></a>
		</li>
	<?php endforeach; ?>
	</ul>
</div>

