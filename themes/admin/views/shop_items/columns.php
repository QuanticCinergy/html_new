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
					<li><a href="#" id="add-column" class="generic_button large float-left">Add Field</a></li>
				</ul>
				
				<?php echo form_open('admin/shop_items/create_column'); ?>
					<div class="form-row"><label>Column Name</label>
					<input type="text" name="column"></div>
					<div class="form-row"><label>Column Type</label>
					<select size="1" name="type">
					<option value="int">Number(Integer)</option>
					<option value="varchar" selected>Small Text(Varchar)</option>
					<option value="text">Big Text(TEXT)</option>
					</select></div>
					
					<input type="submit" value="Create">
				</form>

	


				<ul class="big-list">
				<?php foreach($columns as $column) : ?>
					<li>
						<h3><?php echo $column['column']; ?></h3>
						<ul class="buttons"><li><?php echo link_to('Remove', 'admin/shop_items/remove_column/column/'.$column['column'], '.delete'); ?></li></ul>
					</li>
				<?php endforeach; ?>
				</ul>

</div>