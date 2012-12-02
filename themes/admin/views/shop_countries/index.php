<h1>Shop Countries</h1>
<div id="subnav"> 
				<ul> 
					<li><a href="/admin/shop_items/index/">Products</a></li>
					<li><a href="/admin/shop_categories/index/">Categories</a></li>
                    <li><a href="/admin/shop_brands/index/">Brands</a></li> 
					<li class="active"><a href="/admin/shop_countries/index/">Countries</a></li>
					<li><a href="/admin/orders/index/">Orders</a></li>
					<li><a href="/admin/orders/offers/">Offers</a></li>
					<li><a href="/admin/orders/reports/">Reports</a></li>
				</ul> 
			</div> 
			
			<div id="mainbody" class="with-subnav"> 
				<ul class="action-buttons"> 
					<li><a href="/admin/shop_countries/add/" class="generic_button large">Add Shop Country</a></li> 
				</ul><br>
				<?php if(count($countries) > 0) : ?>
				<div class="component-block"> 
				
					<table cellpadding="0" cellspacing="0"> 
						<tr class="lead"> 
							<th class="title">Name</th> 
							<th>Postage cost</th>
							<th class="date">Created</th> 
							<th class="controls"></th> 
						</tr>
						<?php foreach($countries as $country) : ?> 
						<tr> 
							<td class="article-info"> 
								<a href="/admin/shop_countries/edit/id/<?php echo $country->id; ?>/" class="article-title"><?php echo $country->name; ?></a> 
								<span class="section"></span> 
							</td>
							<td>&euro;<?php echo number_format($country->postage, 2); ?></td>
							<td class="date"><?php echo $country->created_at; ?></td> 
							<td class="controls-lists"> 
								<ul class="buttons">
									<li><a href="/admin/shop_countries/remove/id/<?php echo $country->id; ?>" class="delete">Delete</a></li> 
									<li><a href="/admin/shop_countries/edit/id/<?php echo $country->id; ?>" class="edit">Edit</a></li> 
								</ul> 
							</td> 
						</tr> 
						<?php endforeach; ?>
						</table> 
				</div>
				<?php else: ?>
				<h1>No countries found.</h1>
				<?php endif; ?>
			</div> 
