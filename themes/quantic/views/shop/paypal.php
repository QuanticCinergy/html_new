<script type="text/javascript">
$(document).ready(function() {

	// Simulate submit click, so the user is being 
	// redirected to PayPal payment page
	$('#submit').trigger('click');

});
</script>

<div id="content" class="has-side">

	<h1 id="page-title">Proceed Payment</h1>
	
	<p>Redirecting to PayPal...</p>
	
	<?php echo form_open($data['action']); ?>
	
		<?php foreach($data['fields'] as $field => $value): ?>
		
			<input type="hidden" id="<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $value; ?>" />
		
		<?php endforeach; ?>
		
		<input type="submit" id="submit" name="submit" value="Submit" class="hidden" />
	
	</form>

</div>

<?php sidebar('main') ?>
