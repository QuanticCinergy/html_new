<h1>Advertisement Slots</h1>
<div id="subnav"> 
				<ul> 
					<li><a href="/admin/ads/index/">Advertisements</a></li> 
					<li class="active"><a href="/admin/ad_slots/index/">Slots</a></li> 
				</ul> 
			</div> 
			
			<div id="mainbody" class="with-subnav"> 
				<ul class="action-buttons"> 
					<li><a href="/admin/ad_slots/add/" class="generic_button large">Add Slot</a></li> 
				</ul><br>
				<?php if(count($slots) > 0) : ?>
				<div class="component-block"> 
				
					<table cellpadding="0" cellspacing="0"> 
						<tr class="lead">
							<th class="title">Name</th>
							<th>Image Width</th>
							<th>Image Height</th>
							<th class="controls"></th> 
						</tr>
						<?php foreach($slots as $slot) : ?> 
						<tr>
							<td><?php echo humanize($slot->name); ?></td>
							<td><?php echo $slot->image_width; ?></td>
							<td><?php echo $slot->image_height; ?></td>
							<td class="controls-lists"> 
								<ul class="buttons">
									<li><a href="/admin/ad_slots/remove/id/<?php echo $slot->id; ?>" class="delete">Delete</a></li> 
									<li><a href="/admin/ad_slots/edit/id/<?php echo $slot->id; ?>" class="edit">Edit</a></li> 
								</ul> 
							</td> 
						</tr> 
						<?php endforeach; ?>
						</table> 
				</div>
				<?php else: ?>
				<p class="none">No ad slots found</p>
				<?php endif; ?>
			</div> 
