<div id="content" class="has-side">

<h1 id="page-title"><?php echo $item->name; ?></h1>
            
            <div id="product-sum-wrap">
            <div id="product-image">
             <?php echo img($item->photo_url); ?>
            </div>
            
            <div id="product-summary">
             
             
             <div class="info">
          		
          		<?php if($item->digital == 1 OR ($item->digital == 0 && $item->stock > 0)): ?>
          			
          			<p class="green in-stock">In Stock</p>
          			
          		<?php else: ?>
          		
          			<p class="red in-stock">Out of Stock</p>
          			
          			<?php if(current_user() && $notification == FALSE): ?>
          			
          				<p>
          					<a href="/shop/notify/<?php echo $item->id; ?>">Notify me</a> when it's in stock!
          				</p>
          			
          			<?php endif; ?>
          		
          		<?php endif; ?>
          		
              <p class="the-price">&euro; <?php echo $item->price; ?></p>
             </div>
             
             <?php if($item->language == 1): ?>
             
		         <div class="row">
		         <label class="label">Language</label>
		         <select class="select">
		          <option selected="selected">British</option>
		          <option>Netherlands</option>
		         </select>
		         <span class="required">*</span>
		         </div>
             
             <?php endif; ?>
             
             <?php if(is_array($this->cart) && array_key_exists($item->id, $this->cart)): ?>
             
             	<!-- Item is already in the cart -->
             	<p>This product is already in your cart!</p>
             	<p><a class="generic_button float-left" href="/shop/cart_remove/<?php echo $item->id; ?>">Remove from my Bag</a></p>
             
             <?php elseif($item->digital == 0 && $item->stock == 0): ?>
             
             	<!-- Item is out of stock -->
             
             <?php else: ?>
             
             	<!-- Add item to cart -->
		         <div class="row">
		          <label class="label">Quantity</label>
		          <input type="text" id="quantity" name="quantity" value="1" class="text qty" /> 
		          <span class="required">*</span>
		         </div>
		         
		         <script type="text/javascript">
		         $(document).ready(function() {
		         
		         	// Init Add to cart button
		         	$('#to_cart').click(function() {
		         	
		         		window.location = '/shop/cart_add/<?php echo $item->id; ?>/' + $('#quantity').val();
		         		return false;
		         	
		         	});
		         
		         });
		         </script>
		         
		         
		         
		         	<?php echo form_button('to_cart', 'Add to Bag', 'id="to_cart" class="generic_button"'); ?>
		         
		      
             
             <?php endif; ?>
             
            </div>
            </div>
            
            <section>
	            <header>
	             <h2>Product Description</h2>
	            </header>
	            
	            <div class="prod-description">
	            	<?php echo $item->description; ?>
	            </div>
            </section>
            
            <?php if( ! empty($item->specification)): ?>
            <section>
	            <header>
	             <h2>Product Specification</h2>
	            </header>
	            
	            <div class="prod-specification">
	            	<?php echo $item->specification; ?>
	            </div>
            </section>
            
            <?php endif; ?>
        
       
<?php echo partial('comments', array(
	'model' => $item
)); ?>

</div>
<?php sidebar('shop') ?>
