<h1>Shop Brands</h1>
<div id="subnav"> 
				<ul> 
					<li><a href="/admin/shop_items/index/">Products</a></li>
					<li><a href="/admin/shop_categories/index/">Categories</a></li>
                    <li class="active"><a href="/admin/shop_brands/index/">Brands</a></li>
					<li><a href="/admin/shop_countries/index/">Countries</a></li>
					<li><a href="/admin/orders/index/">Orders</a></li>
					<li><a href="/admin/orders/offers/">Offers</a></li>
					<li><a href="/admin/orders/reports/">Reports</a></li>
				</ul> 
			</div> 
			
			<div id="mainbody" class="with-subnav"> 
				<ul class="action-buttons"> 
					<li><a href="/admin/shop_brands/add/" class="generic_button large">Add Shop Brand</a></li> 
				</ul><br>
				<?php if(count($brands) > 0) : ?>
				<div class="component-block"> 
				
					<table cellpadding="0" cellspacing="0"> 
						<tr class="lead"> 
							<th class="title">Name</th> 
							<th class="date">Created</th> 
							<th class="controls"></th> 
						</tr>
						<?php foreach($brands as $brand) : ?> 
						<tr> 
							<td class="article-info"> 
								<a href="/admin/shop_brands/edit/id/<?php echo $brand->id; ?>/" class="article-title"><?php echo $brand->name; ?></a> 
								<span class="section"></span> 
							</td>
							<td class="date"><?php echo $brand->created_at; ?></td> 
							<td class="controls-lists"> 
								<ul class="buttons">
									<li><a href="/admin/shop_brands/remove/id/<?php echo $brand->id; ?>" class="delete">Delete</a></li> 
									<li><a href="/admin/shop_brands/edit/id/<?php echo $brand->id; ?>" class="edit">Edit</a></li> 
								</ul> 
							</td> 
						</tr> 
						<?php endforeach; ?>
						</table> 
				</div>
				<?php else: ?>
				<h1>No brands found.</h1>
				<?php endif; ?>
			</div> 
