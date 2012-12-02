<h1>Add Pricing Group</h1>
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
			<h2 class="form-head">Add New Pricing Group</h2>
			<?php echo partial('validation'); ?>
			<?php echo form_open('admin/shop_price_groups/create'); ?>
			<div class="form-row">
				<label>Name</label>
				<?php echo form_input('name'); ?>
			</div>

			<div class="form-row">
				<?php echo form_submit('submit', 'Create'); ?>
				<a href="/admin/shop_price_groups/index/" class="cancel">Cancel</a>
			</div>
			</form>
			</div>
