<h1>Orders</h1>
<div id="subnav"> 
	<ul> 
		<li><a href="/admin/shop_items/index/">Products</a></li>
		<li><a href="/admin/shop_categories/index/">Categories</a></li> 
        <li><a href="/admin/shop_brands/index/">Brands</a></li> 
		<li><a href="/admin/shop_countries/index/">Countries</a></li>
		<li class="active"><a href="/admin/orders/index">Orders</a></li>
		<li><a href="/admin/orders/offers/">Offers</a></li>
		<li><a href="/admin/orders/reports/">Reports</a></li>
	</ul> 
</div> 

<div id="mainbody" class="with-subnav"> 
	<h2 class="form-head">View Order</h2>

	<!-- Order ID -->
	<div class="form-row">
		<label>Order Number</label>
		<?php echo $order->id; ?>
	</div>
	
	<div class="form-row">
		<label>User</label>
		<?php if(isset($user->username) && strlen($user->username) > 0) { ?>
			<a href="/admin/users/edit/id/<?php echo $user->id; ?>"><?php echo $user->username; ?></a>
		<?php } elseif(isset($user->first_name) && strlen($user->first_name) > 0) { ?>
			<a href="/admin/users/edit/id/<?php echo $user->id; ?>"><?php echo $user->first_name.' '.$user->last_name; ?></a>
		<?php } else { ?>
			<a href="/admin/users/edit/id/<?php echo $user->id; ?>"><?php echo $user->email; ?></a>
		<?php } ?>
	</div>
	
	<div class="form-row">
		<label>Created</label>
		<?php echo $order->created_at; ?>
	</div>
	
	<div class="form-row">
		<label>Price</label>
		<?php echo $order->total_price; ?>
	</div>
	
	<div class="form-row">
		<label>Payment method</label>
		<?php echo ucfirst($order->payment_method); ?>
	</div>
	
	<div class="form-row">
		<label>Status</label>
		<?php echo ucfirst($order->status); ?>
	</div>
	
	<div class="form-row">
		<label>Paid</label>
		<?php echo ($order->paid == 1) ? 'Yes' : 'No'; ?>
	</div>
	
	<!-- Shopping cart -->
	<br />
	<h3>Shopping cart</h3>
	<br />
	
	<table width="100%" id="shopping_cart">
		<tr>
			<td>Item ID</td>
			<td>Name</td>
			<td>Quantity</td>
			<td>Offer Code</td>
			<td>Price per item</td>
			<td>Total price</td>
		</tr>
		
		<?php foreach($cart as $product): ?>
			
			<?php
			$product->name = ($product->variation_name !== NULL) ? $product->name.' - '.$product->variation_name : $product->name;
			?>
		
			<tr>
				<td><?php echo $product->id; ?></td>
				<td><a href="<?= site_url('admin/shop_items/edit/id/').'/'.$product->id; ?>"><?php echo $product->name; ?></a></td>
				<td><?php echo $product->quantity; ?></td>
				
				<td>
					<a href="<?= site_url('admin/shop_items/edit/id/').'/'.$product->id; ?>">
						<?= (strlen($product->offer_code) > 0) ? $product->offer_code : ''; ?>
					</a>
				</td>
				
				<td><?php echo number_format($product->item_price, 2); ?></td>
				<td><?php echo number_format(($product->quantity * $product->item_price), 2); ?></td>
			</tr>
		
		<?php endforeach; ?>
	</table>
	
	<?php
	$shipping_details = unserialize($order->shipping_details);
	?>
	
	<?php if(is_array($shipping_details) && count($shipping_details) > 0 && 
			 isset($count->postage) && isset($country->name)): ?>
	
		<!-- Postage cost -->
		<br />
		<p><b>Postage cost</b>: &euro;<?php echo $country->postage; ?> (<i><?php echo $country->name; ?></i>)</p>
	
	<?php endif; ?>
	
	<!-- Shipping details -->
	<?php if(is_array($shipping_details) && count($shipping_details) > 0): ?>
	
		<br />
		<h3>Shipping Details</h3>
		<br />
		
		<div class="form-row">
			<label>Full name</label> 
			<?php echo $shipping_details['full_name']; ?>
		</div>
		
		<div class="form-row">
			<label>Email Address</label> 
			<?php echo $user->email; ?>
		</div>
		
		<div class="form-row">
			<label>1st line of address</label> 
			<?php echo $shipping_details['house_number']; ?> <?php echo $shipping_details['street']; ?>
		</div>
				
		<?php if( ! empty($shipping_details['address_2nd'])): ?>
		
			<div class="form-row">
				<label>2nd line of address</label> 
				<?php echo $shipping_details['address_2nd']; ?>
			</div>
		
		<?php endif; ?>
		
		<div class="form-row">
			<label>City</label> 
			<?php echo $shipping_details['city']; ?>
		</div>
		
		<?php if( ! empty($shipping_details['county'])): ?>
		
			<div class="form-row">
				<label>County</label> 
				<?php echo $shipping_details['county']; ?>
			</div>
		
		<?php endif; ?>
		
		<div class="form-row">
			<label>Postal code</label> 
			<?php echo $shipping_details['postal_code']; ?>
		</div>
		
		<div class="form-row">
			<label>Country</label> 
			<?php echo $country->name; ?>
		</div>
		
		<div class="form-row">
			<label>Postage</label>
			<?php
			echo (isset($shipping_details['shipping']['name'])) ? $shipping_details['shipping']['name'] : 'Unknown';
			?>
			<?php
			echo ' - &euro;';
			echo (isset($shipping_details['shipping']['postage'])) ? number_format($shipping_details['shipping']['postage'], 2) : 'Unknown';
			?>
		</div>
	
	<?php endif; ?>
	
</div>
