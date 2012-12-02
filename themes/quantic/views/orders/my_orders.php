<script type="text/javascript">
$(document).ready(function() {

	// Confirmation box for cancel order
	$('a.cancel').click(function() {
	
		if( ! confirm('Are you sure you want to cancel this order?'))
		{
			return false;
		}
	
	});

});
</script>

<div id="content" class="has-side">

	<section id="my_orders">
	
		<header>
			<h1 id="page-title">My Orders</h1>
		</header>
		
		<p>You have <b><?php echo $total_orders; ?></b> orders total.</p>
		
		<table width="100%" id="my_orders">
			<tr>
				<th>Order ID</th>
				<th>Order Placed</th>
				<th>Status</th>
				<th></th>
			</tr>
			
			<?php foreach($my_orders as $my_order): ?>
			
				<tr>
					<td><?php echo $my_order->id; ?></td>
					<td><span class="meta"><?php echo date('D jS  H:i:s', $my_order->created_at); ?></span></td>
					<td><strong><?php echo $my_order->status; ?></strong></td>
					<td>
						<?php if($my_order->status == 'processing' && $my_order->paid == 0): ?>
							
							<a class="generic_button float-right" href="/my_orders/cancel/<?php echo $my_order->id; ?>" class="cancel">Cancel</a>
							
						<?php endif; ?>
					</td>
				</tr>
			
			<?php endforeach; ?>
		</table>
	
	</section>

</div>

<?php sidebar('main'); ?>
