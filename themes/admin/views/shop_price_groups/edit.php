<h1>Edit Pricing Group</h1>

<div id="subnav"> 
				<ul> 
					<li><a href="/admin/shop_items/index/">Products</a></li>
					<li><a href="/admin/shop_categories/index/">Categories</a></li> 
                    <li><a href="/admin/shop_brands/index/">Brands</a></li> 
					<li><a href="/admin/shop_countries/index/">Countries</a></li>
					<li class="active"><a href="/admin/shop_price_groups/index/">Pricing Groups</a></li>					
					<li><a href="/admin/orders/index">Orders</a></li>
					<li><a href="/admin/orders/offers/">Offers</a></li>
					<li><a href="/admin/orders/reports/">Reports</a></li>
				</ul> 
			</div> 
			
			<div id="mainbody" class="with-subnav"> 
				<h2 class="form-head">Edit Pricing Group</h2>
				<?php echo partial('validation'); ?>
				<?php echo form_open('admin/shop_price_groups/update'); ?>
				<?php echo form_hidden('id', $group->id); ?>
					<div class="form-row">
						<label>Name</label>
						<?php echo form_input('name', $group->name); ?>
					</div>
					
					<div class="form-row">
						<?php echo form_submit('submit', 'Update'); ?>
						<a href="/admin/shop_price_groups/index/" class="cancel">Cancel</a>
					</div>
				</form>
			</div>
