<h1>Sponsors</h1>
<div id="subnav"> 
				<ul> 
					<li><a href="/admin/sponsors/index/">Sponsors</a></li> 
					<li class="active"><a href="/admin/sponsor_categories/index/">Categories</a></li> 
				</ul> 
			</div> 
			
			<div id="mainbody" class="with-subnav"> 
				<ul class="action-buttons"> 
					<li><a href="/admin/sponsor_categories/add/" class="generic_button large">Add Category</a></li> 
				</ul><br>
				<?php if(count($categories) > 0) : ?>
				<div class="component-block"> 
				
					<table cellpadding="0" cellspacing="0"> 
						<tr class="lead">
							<th class="title">Name</th>
							<th class="controls"></th> 
						</tr>
						<?php foreach($categories as $category) : ?> 
						<tr>
							<td><?php echo $category->name; ?></td>
							<td class="controls-lists"> 
								<ul class="buttons">
									<li><a href="/admin/sponsor_categories/remove/id/<?php echo $category->id; ?>" class="delete">Delete</a></li> 
									<li><a href="/admin/sponsor_categories/edit/id/<?php echo $category->id; ?>" class="edit">Edit</a></li> 
								</ul> 
							</td> 
						</tr> 
						<?php endforeach; ?>
						</table> 
				</div>
				<?php else: ?>
				<p class="none">No sponsor categories found</p>
				<?php endif; ?>
			</div> 
