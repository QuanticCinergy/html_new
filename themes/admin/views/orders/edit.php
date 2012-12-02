<h1>Orders</h1>
<div id="subnav"> 
				<ul> 
					<li><a href="/admin/shop_items/index/">Products</a></li>
					<li><a href="/admin/shop_categories/index/">Categories</a></li> 
                    <li><a href="/admin/shop_brands/index/">Brands</a></li> 
					<li><a href="/admin/shop_countries/index/">Countries</a></li>
					<li class="active"><a href="/admin/orders/index">Orders</a></li>
					<li><a href="/admin/orders/offers/">Offers</a></li>
					<li><a href="/admin/orders/reports/">Reports</a></li>
				</ul> 
			</div> 
			
			<div id="mainbody" class="with-subnav"> 
			<h2 class="form-head">Edit Order</h2>
			<?php echo partial('validation'); ?>
			<?php echo form_open('admin/orders/update'); ?>
			<?php echo form_hidden('id', $order->id); ?>
			<div class="form-row">
				<label>Status</label>
				<?php 
				echo form_dropdown('status', array(
					'failed'     => 'Failed',
					'processing' => 'Processing',
					'packing'    => 'Packing',
					'delivered'  => 'Dispatched'
				), $order->status); 
				?>
			</div>
			<div class="form-row">
				<label>Paid</label>
				<?php
				echo form_dropdown('paid', array(
					0	=> 'No',
					1	=> 'Yes'
				), $order->paid);
				?>
			</div>
			<div class="form-row">
				<?php echo form_submit('submit', 'Update'); ?>
				<a href="/admin/orders/index/" class="cancel">Cancel</a>
			</div>
			</form>
			</div>
