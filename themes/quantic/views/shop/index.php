

<div id="content" class="has-side">         
            <h1 id="page-title">Shop <?php echo param('category'); ?></h1>
            
                 
            <section id="latest">
	            <header>
	            	<h2>Latest Products</h2>
	            </header>        

	            <?php echo $pagination; ?>
	            <ul class="shop-items">
	            	<?php foreach($items as $item) : ?>
	            	
	            		<li>
	            			<div class="prod-img">
	            				<?php if($item->stock < 1): ?>
	            					<span class="out-of-stock">Out of Stock</span>
	            				<?php else: ?>
	            				<?php endif; ?>
	            				<img src="<?php echo $item->photo_url; ?>" alt="<?php echo $item->name ; ?>" />
	            			</div>
	            			<h3><?= link_to($item->name, shop_item_url($item->category->url_name, $item->brand->url_name, $item->id, $item->url_name)) ?></h3>
	            			<span class="the-price">&euro;<?php echo $item->price; ?></span>
	            		</li>
		           
		            <?php endforeach; ?>
	            </ul>
				<?php echo $pagination; ?>
            </section>            

</div>

<?php sidebar('shop') ?>
