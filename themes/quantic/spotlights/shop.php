<script>
$('.slideshow').cycle({
	fx: 'fade',
	speed: 'slow',
	timeout: 5000,
	pager: '.main-car-nav',
	pagerAnchorBuilder: function(idx, slide) {
// return selector string for existing anchor
return '.main-car-nav li:eq(' + idx + ') a';
}
	});
	$('#direct').click(function() {
	$('.main-car-nav li:eq(2) a').trigger('click');
	return false;
}); 
</script>

<div id="carousel_surround" style="<?php if($this->uri->segment(1) == ''): echo 'margin-bottom:0;'; endif; ?>">
	<div id="carousel">
		<!-- CAROUSEL NAV -->
		<div class="carousel-nav">
			<ul class="main-car-nav">
	        	<?php foreach($spotlight->items as $item) : ?>
			    <li>
			        <a href="#">
			        	<img src="<?php echo $item->image_url; ?>" width="55" height="30" />		        
			        </a>
				</li>
			   <?php endforeach; ?>
	   		</ul>
	   	</div>		
		<ul class="slideshow">
		
		<?php foreach($spotlight->items as $item) : ?>
		<li>
	
			<div class="carousel-copy">
				<h2><a href="<?php echo $item->url; ?>"><?php echo $item->headline; ?></a></h2>
				<?php echo $item->description; ?>
			</div>
			<a href="<?php echo $item->url; ?>"><img src="<?php echo $item->image_url; ?>" width="630" height="309" /></a>
			
		</li>
		<?php endforeach; ?>
		</ul>		
	</div>

</div>