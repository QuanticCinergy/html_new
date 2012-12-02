<script>

function mycarousel_initCallback(carousel)
{
// Disable autoscrolling if the user clicks the prev or next button.
carousel.buttonNext.bind('click', function() {
carousel.startAuto(0);
});
carousel.buttonPrev.bind('click', function() {
carousel.startAuto(0);
});
// Pause autoscrolling if the user moves with the cursor over the clip.
carousel.clip.hover(function() {
carousel.stopAuto();
}, function() {
carousel.startAuto();
});
};
jQuery(document).ready(function() {
jQuery('#sponsors').jcarousel({
auto: 4,
wrap: 'circular',
initCallback: mycarousel_initCallback
});
}); 

</script>

<div id="sponsors" class="grad-bg carousel jcarousel-container jcarousel-container-horizontal">
	<div class="jcarousel-clip jcarousel-clip-horizontal">
		<ul class="list jcarousel-list jcarousel-list-horizontal">
		<?php foreach($spotlight->items as $item) : ?>
			<li>
				<a href="<?php echo $item->url; ?>"><img src="<?php echo $item->image_url; ?>" width="200" height="80" /></a>
			</li>
		<?php endforeach; ?>
		</ul>
	</div>
</div>	

