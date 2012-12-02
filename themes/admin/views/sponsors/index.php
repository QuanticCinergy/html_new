<h1>Sponsors</h1>
<div id="subnav"> 
				<ul> 
					<li class="active"><a href="/admin/sponsors/index/">Sponsors</a></li> 
					<li><a href="/admin/sponsor_categories/index/">Categories</a></li> 
				</ul> 
			</div> 
			
			<div id="mainbody" class="with-subnav"> 
				<ul class="action-buttons"> 
					<li><a href="/admin/sponsors/add/" class="generic_button large">Add Sponsor</a></li> 
				</ul><br>
				<?php if(count($sponsors) > 0) : ?>
				<div class="component-block"> 
				
					<table cellpadding="0" cellspacing="0"> 
						<tr class="lead"> 
							<th class="img">Image</th>
							<th class="title">Name</th>
							<th class="description">Description</th> 
							<th class="date">Created</th> 
							<th class="controls"></th> 
						</tr>
						<?php foreach($sponsors as $sponsor) : ?> 
						<tr> 
							<td><?php echo img($sponsor->logo_thumb_url); ?></td>
							<td><?php echo $sponsor->name; ?></td>
							<td><?php echo $sponsor->description; ?></td>
							<td class="date"><?php echo $sponsor->created_at; ?></td> 
							<td class="controls-lists"> 
								<ul class="buttons">
									<li><a href="/admin/sponsors/remove/id/<?php echo $sponsor->id; ?>" class="delete">Delete</a></li> 
									<li><a href="/admin/sponsors/edit/id/<?php echo $sponsor->id; ?>" class="edit">Edit</a></li> 
								</ul> 
							</td> 
						</tr> 
						<?php endforeach; ?>
						</table> 
				</div>
				<?php else: ?>
				<p class="none">No sponsors found</p>
				<?php endif; ?>
			</div> 
