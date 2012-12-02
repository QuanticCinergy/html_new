<h1>Advertisements</h1>
<div id="subnav"> 
				<ul> 
					<li class="active"><a href="/admin/ads/index/">Advertisements</a></li> 
					<li><a href="/admin/ad_slots/index/">Slots</a></li> 
				</ul> 
			</div> 
			
			<div id="mainbody" class="with-subnav"> 
				<ul class="action-buttons"> 
					<li><a href="/admin/ads/add/" class="generic_button large">Add Advertisement</a></li> 
				</ul><br>
				<?php if(count($ads) > 0) : ?>
				<div class="component-block"> 
				
					<table cellpadding="0" cellspacing="0"> 
						<tr class="lead"> 
							<th class="img">Image</th>
							<th class="title">Name</th>
							<th class="controls"></th> 
						</tr>
						<?php foreach($ads as $ad) : ?> 
						<tr> 
							<td><?php echo img($ad->image_thumb_url); ?></td>
							<td class="preview-image"><?php echo $ad->name; ?></td>
							<td class="controls-lists"> 
								<ul class="buttons">
									<li><a href="/admin/ads/remove/id/<?php echo $ad->id; ?>" class="delete">Delete</a></li> 
									<li><a href="/admin/ads/edit/id/<?php echo $ad->id; ?>" class="edit">Edit</a></li> 
								</ul> 
							</td> 
						</tr> 
						<?php endforeach; ?>
						</table> 
				</div>
				<?php else: ?>
				<p class="none">No ads found</p>
				<?php endif; ?>
			</div> 
