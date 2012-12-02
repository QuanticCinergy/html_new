<h1>Orders</h1>
<div id="subnav"> 
	<ul> 
		<li><a href="/admin/shop_items/index/">Products</a></li>
		<li><a href="/admin/shop_categories/index/">Categories</a></li>
		<li><a href="/admin/shop_brands/index/">Brands</a></li> 
		<li><a href="/admin/shop_countries/index/">Countries</a></li>
		<li class="active"><a href="/admin/orders/index/">Orders</a></li>
		<li><a href="/admin/orders/offers/">Offers</a></li>
		<li><a href="/admin/orders/reports/">Reports</a></li>
	</ul> 
</div> 

<div id="mainbody" class="with-subnav">
	<?php if(count($orders) > 0) : ?>
	<div class="component-block"> 
	
		<table cellpadding="0" cellspacing="0"> 
			<tr class="lead"> 
				<th>Order No.</th>
				<th>User</th>
				<th>Price</th>
				<th>Status</th>
				<th>Paid</th>
				<th class="date">Created</th> 
				<th id="offer_code">Offer Code Used</th>
				<th class="controls"></th> 
			</tr>
			<?php foreach($orders as $order) : ?>
			<tr>
				<td><?php echo $order->id; ?></td>
				<td><?php echo $order->full_name; ?></td>	
				<td><?php echo number_format($order->total_price, 2); ?></td>
				<td><?php echo ucfirst($order->status); ?></td>
				<td><?php echo ($order->paid == 1) ? 'Yes' : 'No'; ?></td>
				<td class="date"><?php echo $order->created_at; ?></td>
				
				<? if($order->offer_code_used) { ?>
					<td class="offer_code">Yes (<?=$order->offer_code_count;?>)</td>
				<? } else { ?>
					<td class="offer_code">No</td>
				<?php } ?>
				
				<td class="controls-lists"> 
					<ul class="buttons">
						<li><a href="/admin/orders/view/id/<?php echo $order->id; ?>" class="view">View</a></li>
						<li><a href="/admin/orders/remove/id/<?php echo $order->id; ?>" class="delete">Delete</a></li> 
						<li><a href="/admin/orders/edit/id/<?php echo $order->id; ?>" class="edit">Edit</a></li> 
					</ul> 
				</td> 
			</tr> 
			<?php endforeach; ?>
			</table> 
			<div class="pagination"><?= $pagination ?></div>
	</div>
	<?php else: ?>
	<p class="none">No orders found.</p>
	<?php endif; ?>
</div> 