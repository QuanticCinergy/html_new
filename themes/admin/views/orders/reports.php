<h1>Orders</h1>
<div id="subnav"> 
	<ul> 
		<li><a href="/admin/shop_items/index/">Products</a></li>
		<li><a href="/admin/shop_categories/index/">Categories</a></li>
		<li><a href="/admin/shop_brands/index/">Brands</a></li> 
		<li><a href="/admin/shop_countries/index/">Countries</a></li>
		<li><a href="/admin/orders/index/">Orders</a></li>
		<li><a href="/admin/orders/offers/">Offers</a></li>
		<li class="active"><a href="/admin/orders/reports/">Reports</a></li>
	</ul> 
</div> 

<div id="mainbody" class="with-subnav">
	<?php if(count($reports) > 0) : ?>
	<div class="component-block"> 
	
		<table cellpadding="0" cellspacing="0"> 
			<tr class="lead"> 
				<th>Date</th>
				<th>Number of Orders</th>
				<th>Download</th>
			</tr>
			<?php foreach($reports as $report) : ?>
			<tr>
				<td><?=date("d/m/Y", $report['start']);?> - <?=date("d/m/Y", $report['end']);?></td>
				<td><?=$report['count'];?></td>
				<td>
					<a href="<?=site_url('admin/orders/reports/download/'.$report['start']).'-'.$report['end'];?>">Download</a>
				</td>
			</tr> 
			<?php endforeach; ?>
			</table> 
	</div>
	<?php else: ?>
	<p class="none">No orders found.</p>
	<?php endif; ?>
</div>