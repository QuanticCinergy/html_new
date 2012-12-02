
<h1>Shop Brands</h1>
<div id="subnav"> 
				<ul> 
					<li><a href="/admin/shop_items/index/">Products</a></li>
					<li><a href="/admin/shop_categories/index/">Categories</a></li> 
                    <li class="active"><a href="/admin/shop_brands/index/">Brands</a></li> 
					<li><a href="/admin/shop_countries/index/">Countries</a></li>
					<li><a href="/admin/orders/index">Orders</a></li>
					<li><a href="/admin/orders/offers/">Offers</a></li>
					<li><a href="/admin/orders/reports/">Reports</a></li>
				</ul> 
			</div> 
			
			<div id="mainbody" class="with-subnav"> 
			<h2 class="form-head">Add New Brand</h2>
			<?php echo partial('validation'); ?>
			<?php echo form_open_multipart('admin/shop_brands/create'); ?>
			<div class="form-row">
				<label>Name</label>
				<?php echo form_input('name'); ?>
			</div>
            
            <div class="form-row">
				<label>Description</label>
				<?php echo form_textarea('description', '', 'class="short"'); ?>
			</div>
			
			<div class="form-row">
				<label>Editor Introduction</label>
				<?php echo form_textarea('editor_intro', '', 'class="full"'); ?>
			</div>
			
			<div class="form-row">
				<label>Subscription Information</label>
				<?php echo form_textarea('subscription_info', '', 'class="full"'); ?>
			</div>
			
            <div class="form-row">
				<label>Side Content</label>
				<?php echo form_textarea('side_content', '', 'class="full"'); ?>
			</div>
            
			<div class="form-row">
				<label>Image</label>
				<?php echo form_upload('image'); ?>
			</div>
			
			<div class="form-row">
				<label>Logo</label>
				<?php echo form_upload('image2'); ?>
			</div>

			<div class="form-row">
				<?php echo form_submit('submit', 'Create'); ?>
				<a href="/admin/shop_brands/index/" class="cancel">Cancel</a>
			</div>
			</form>
			</div>