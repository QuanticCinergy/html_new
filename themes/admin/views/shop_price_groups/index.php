<h1>Pricing Groups</h1>
<div id="subnav"> 
				<ul> 
					<li><a href="/admin/shop_items/index/">Products</a></li>
					<li><a href="/admin/shop_categories/index/">Categories</a></li>
                    <li><a href="/admin/shop_brands/index/">Brands</a></li> 
					<li><a href="/admin/shop_countries/index/">Countries</a></li> 
					<li class="active"><a href="/admin/shop_price_groups/index/">Pricing Groups</a></li>
					<li><a href="/admin/orders/index/">Orders</a></li>
					<li><a href="/admin/orders/offers/">Offers</a></li>
					<li><a href="/admin/orders/reports/">Reports</a></li>
				</ul> 
			</div> 
			
			<div id="mainbody" class="with-subnav"> 
				<ul class="action-buttons"> 
					<li><a href="/admin/shop_price_groups/add/" class="generic_button large">Add Pricing Group</a></li> 
				</ul><br>
				<?php if(count($groups) > 0) : ?>
				<div class="component-block"> 
				
					<table cellpadding="0" cellspacing="0"> 
						<tr class="lead"> 
							<th class="title">Name</th> 
							<th class="date">Created</th> 
							<th class="controls"></th> 
						</tr>
						<?php foreach($groups as $group) : ?> 
						<tr> 
							<td class="article-info"> 
								<a href="/admin/shop_price_groups/edit/id/<?php echo $group->id; ?>/" class="article-title"><?php echo $group->name; ?></a> 
								<span class="section"></span> 
							</td>
							<td class="date"><?php echo $group->created_at; ?></td> 
							<td class="controls-lists"> 
								<ul class="buttons">
									<li><a href="/admin/shop_price_groups/remove/id/<?php echo $group->id; ?>" class="delete">Delete</a></li> 
									<li><a href="/admin/shop_price_groups/edit/id/<?php echo $group->id; ?>" class="edit">Edit</a></li> 
								</ul> 
							</td> 
						</tr> 
						<?php endforeach; ?>
						</table> 
				</div>
				<?php else: ?>
				<h1>No pricing groups found.</h1>
				<?php endif; ?>
			</div> 
