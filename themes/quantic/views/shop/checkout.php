<?php
// Check if at least one product in the cart is not digital,
// that means shipping details are required to fill
$shipping_details = FALSE;

foreach($this->cart as $product)
{
	if($product['digital'] == 0)
	{
		$shipping_details = TRUE;
		break;
	}
}
?>

<div id="content" class="has-side">

	<h1 id="page-title">Checkout</h1>
	
	<p>This is the last step before proceeding with payment, please recheck the contents of your 
	shopping cart, fill the shipping data (<i>if required</i>) and choose your preferred 
	payment method.</p>
	<br />
	
	<!-- Cart -->
	<section id="cart">
	
		<header>
			<h2>Your Cart</h2>
		</header>
		
		<?php $total_price = 0; ?>
		
		<?php echo form_open('/shop/cart_process'); ?>
		
			<table with="100%" id="cart">
				<tr>
					<td>Quantity</td>
					<td>Product</td>
					<td>Price</td>
					<td>Actions</td>
				</tr>
			
				<?php foreach($this->cart as $product): ?>
			
					<tr>
						<td>
							<input value="<?php echo $product['quantity']; ?>" type="text" name="quantity_<?php echo $product['item_id']; ?>" autocomplete="off" /> 
						</td>
						<td>
							<a href="<?php echo $product['item_url']; ?>"><?php echo $product['name']; ?></a> 
						</td>
						<td>
							&pound;<?php echo ($product['quantity'] * $product['price']); ?>
						</td>
						<td>
							<a href="/shop/cart_remove/<?php echo $product['item_id']; ?>" class="cart_remove">Remove</a>
						</td>
					</tr>
					<?php $total_price = $total_price + ($product['quantity'] * $product['price']); ?>
			
				<?php endforeach; ?>
			
			</table>
			<br />
	
			<p><h3>Total: &pound;<?php echo $total_price; ?></h3></p>
	
			<div class="button-wrap">
				<input type="submit" name="update" value="Update" class="generic_button float-right" />
			</div>
			
		</form>
	
	</section>
	
	<?php echo form_open('/shop/init_pay', array('id' => 'pay_form')); ?>
	
		<?php if($shipping_details): ?>
	
			<!-- Shipping details -->
			<script type="text/javascript">
			$(document).ready(function() {
			
				// Form validation using jQuery Validation plugin
				var validator = $('#pay_form').validate({

					rules: {
						full_name: {
							required: true
						},
						house_number: {
							required: true
						},
						street: {
							required: true
						},
						city: {
							required: true
						},
						postal_code: {
							required: true
						},
						country: {
							required: true
						}
					}

				});
			
			});
			</script>
			
			<section id="shipping_details">
	
				<header>
					<h2>Shipping details</h2>
				</header>
	
				<input type="hidden" id="shipping_details" name="shipping_details" value="1" />
	
				<div class="row">
					<label for="full_name">
						Full name <span class="required">*</span>
					</label>
					<input type="text" id="full_name" name="full_name" value="" />
				</div>
			
				<div class="row">
					<label for="house_number">
						House number <span class="required">*</span>
					</label>
					<input type="text" id="house_number" name="house_number" value="" />
				</div>
			
				<div class="row">
					<label for="street">
						Street <span class="required">*</span>
					</label>
					<input type="text" id="street" name="street" value="" />
				</div>
			
				<div class="row">
					<label for="address_2nd">
						2nd line of address
					</label>
					<input type="text" id="address_2nd" name="address_2nd" value="" />
				</div>
			
				<div class="row">
					<label for="city">
						City <span class="required">*</span>
					</label>
					<input type="text" id="city" name="city" value="" />
				</div>
			
				<div class="row">
					<label for="county">
						County / state
					</label>
					<input type="text" id="county" name="county" value="" />
				</div>
			
				<div class="row">
					<label for="postal_code">
						Postal code <span class="required">*</span>
					</label>
					<input type="text" id="postal_code" name="postal_code" value="" />
				</div>
			
				<div class="row">
					<label for="country">
						Country <span class="required">*</span>
					</label>
					<select id="country" name="country">
					
						<?php foreach($this->countries as $country): ?>
					
							<option value="<?php echo $country->id; ?>"><?php echo $country->name; ?> (Postage: &pound;<?php echo $country->postage; ?>)</option>
						
						<?php endforeach ;?>
						
					</select>
				</div>
	
			</section>
	
		<?php endif; ?>
	
		<!-- Payment method -->
		<section id="payment_method">
		
			<header>
				<h2>Payment method</h2>
				<p>Please choose your preferred payment method.</p>
			</header>
		
			<select id="payment_method" name="payment_method">
				<option value="paypal">Paypal</option>
				<option value="sagepay">Sagepay</option>
			</select>
		
			<input type="submit" name="pay" value="Pay" class="generic_button float-right" />
		
		</section>
		
	</form>
	
	<p><a href="/shop">Back to the shop</a></p>

</div>

<?php sidebar('main') ?>
