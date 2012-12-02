<h1>Orders</h1>
<div id="subnav"> 
				<ul> 
					<li><a href="/admin/shop_items/index/">Products</a></li>
					<li><a href="/admin/shop_categories/index/">Categories</a></li>
                    <li><a href="/admin/shop_brands/index/">Brands</a></li> 
					<li><a href="/admin/shop_countries/index/">Countries</a></li>
					<li><a href="/admin/orders/index/">Orders</a></li>
					<li class="active"><a href="/admin/orders/offers/">Offers</a></li>
					<li><a href="/admin/orders/reports/">Reports</a></li>
				</ul> 
			</div> 
			
			<div id="mainbody" class="with-subnav">
				<?php if(count($codes) > 0) : ?>
				<div class="component-block"> 
				
					<table cellpadding="0" cellspacing="0"> 
						<tr class="lead"> 
							<th>Offer Code</th>
							<th>Product</th>
							<th>Times Used</th> 
						</tr>
						<?php foreach($codes as $code) : ?>
						<tr>
							<td><?php echo $code->offer_code; ?></td>
							<td><a href="<?=site_url('admin/shop_items/edit/id').'/'.$code->item_id;?>"><?=$code->name;?></a></td>
							<td><?php echo $code->count; ?></td>
						</tr> 
						<?php endforeach; ?>
						</table> 
				</div>
				<?php else: ?>
				<p class="none">No offer codes have been used yet.</p>
				<?php endif; ?>
			</div> 
