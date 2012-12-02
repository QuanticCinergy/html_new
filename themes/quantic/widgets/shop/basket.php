<div class="sidewidget" id="shopbag">
	<h2>My shopping bag</h2>
	<?php if(empty($this->cart)): ?>

		<!-- Empty bag -->
		<p>At the moment your shopping bag is empty. Please take a look at our products.</p>
	
	<?php else: ?>
	
		<!-- Something's in the bag -->
		<?php $total_price = 0; ?>
		
		<?php echo form_open('/shop/cart_process'); ?>
		
			<div class="summary">
				<ul>
					<?php foreach($this->cart as $product): ?>
				
						<li>
							<a href="/shop/cart_remove/<?php echo $product['item_id']; ?>" class="cart_remove" alt="Remove from my Bag">x</a>
							<input value="<?php echo $product['quantity']; ?>" type="text" name="quantity_<?php echo $product['item_id']; ?>" autocomplete="off" /> 
							<a class="product_name" href="<?php echo $product['item_url']; ?>"><?php echo $product['name']; ?></a> 
							<span class="price">&euro;<?php echo ($product['quantity'] * $product['price']); ?></span>
						</li>
						<?php $total_price = $total_price + ($product['quantity'] * $product['price']); ?>
				
					<?php endforeach; ?>
				
					<li class="total">Total: <h3>&euro;<?php echo $total_price; ?></h3></li>
				</ul>
			</div>
		
			<script type="text/javascript">
			$(document).ready(function() {
			
				// Init checkout button
				$('input[name=checkout]').click(function() {
				
					window.location = '/shop/checkout';
					return false;
				
				});
			
			});
			</script>
		
			<div class="button-wrap">
				<input type="submit" name="checkout" value="Proceed to Payment" class="generic_button float-right" />
				<input type="submit" name="update" value="Update" class="generic_button float-right" />
			</div>
		
		</form>
	
	<?php endif; ?>
</div>
