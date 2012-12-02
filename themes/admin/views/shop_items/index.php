<h1>Shop</h1> 
			
			<div id="subnav"> 
				<ul> 
					<li class="active"><a href="/admin/shop_items/index/">Products</a></li> 
					<li><a href="/admin/shop_categories/index/">Categories</a></li>
                    <li><a href="/admin/shop_brands/index/">Brands</a></li> 
					<li><a href="/admin/shop_countries/index/">Countries</a></li>				
					<li><a href="/admin/orders/index/">Orders</a></li>
					<li><a href="/admin/orders/offers/">Offers</a></li>
					<li><a href="/admin/orders/reports/">Reports</a></li>
				</ul> 
			</div> 
			
			<div id="mainbody" class="with-subnav"> 
				<ul class="action-buttons"> 
					<li><a href="/admin/shop_items/add/" class="generic_button large">Add Product</a></li>
					<li><a href="/admin/shop_items/columns/" class="generic_button large">Custom Fields</a></li> 					
				</ul>
				
				
				
				<?php if(count($items) > 0) : ?>
				
				<div class="component-block"> 
				
					<table cellpadding="0" cellspacing="0"> 
						<tr class="lead"> 
							<th class="img">Photo</th>
							<th class="title">Name</th>
							<th>Price</th>
							<th class="category">Category</th>
                            <th class="brand">Brand</th>
							<th class="date">Posted</th> 
							<th class="controls"></th> 
						</tr> 
						<?php foreach($items as $item) : ?>
						<tr> 
							<td><?php echo img($item->photo_thumb_url); ?></td>
							<td> 
								<a href="/admin/shop_items/edit/id/<?php echo $item->id; ?>/"><?php echo $item->name; ?></a> <br />
								<span class="section"><?php echo $item->status; ?></span> 
							</td>
							
							<?php if(isset($item->from)) { ?>
							<td>From &euro;<?php echo number_format($item->from, 2); ?></td>
							<?php } else { ?>
							<td>&euro;<?php echo number_format($item->price, 2); ?></td>
							<?php } ?>
							
							<td><?php echo link_to($item->category->name, '/admin/shop_items/index/category_id/'.$item->category_id); ?></td>
                            <td><?php echo link_to($item->brand->name, '/admin/shop_items/index/brand_id/'.$item->brand_id); ?></td>
							<td class="date"><?php echo $item->created_at; ?></td> 
							<td class="controls-lists"> 
								<ul class="buttons">
									<li><a href="/admin/shop_items/remove/id/<?php echo $item->id; ?>" class="delete">Delete</a></li> 
									<li><a href="/admin/shop_items/edit/id/<?php echo $item->id; ?>" class="edit">Edit</a></li> 
								</ul> 
							</td> 
						</tr> 
						<?php endforeach; ?>
					</table> 
					
					<div class="pagination">
						<?php echo $pagination; ?>
					</div>
				
				</div> 
				
				<?php else: ?>
				<p class="none">No products found</p>
				<?php endif; ?>
			
			</div> 
