<h1>Edit Shop Category</h1>

<div id="subnav"> 
				<ul> 
					<li><a href="/admin/shop_items/index/">Products</a></li>
					<li class="active"><a href="/admin/shop_categories/index/">Categories</a></li> 
                    <li><a href="/admin/shop_brands/index/">Brands</a></li> 
					<li><a href="/admin/shop_countries/index/">Countries</a></li>
					<li><a href="/admin/orders/index">Orders</a></li>
					<li><a href="/admin/orders/offers/">Offers</a></li>
					<li><a href="/admin/orders/reports/">Reports</a></li>
				</ul> 
			</div> 
			
			<div id="mainbody" class="with-subnav"> 
				<h2 class="form-head">Edit Category</h2>
				<?php echo partial('validation'); ?>
				<?php echo form_open('admin/shop_categories/update'); ?>
				<?php echo form_hidden('id', $category->id); ?>
					<div class="form-row">
						<label>Name</label>
						<?php echo form_input('name', $category->name); ?>
					</div>
                    
                    <div class="form-row">
						<label>Description</label>
						<?php echo form_textarea('description', $category->description, 'class="short"'); ?>
					</div>
					
					<div class="form-row">
						<?php echo form_submit('submit', 'Update'); ?>
						<a href="/admin/shop_categories/index/" class="cancel">Cancel</a>
					</div>
				</form>
			</div>
