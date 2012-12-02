<h1>Guide Categories</h1>
<div id="subnav"> 
				<ul> 
					<li><a href="/admin/guides/index/">Guides</a></li> 
					<li><a href="/admin/guide_sections/index/">Sections</a></li> 
					<li class="active"><a href="/admin/guide_categories/index/">Categories</a></li> 
				</ul> 
			</div> 
			
			<div id="mainbody" class="with-subnav"> 
				<ul class="action-buttons"> 
					<li><a href="/admin/guide_categories/add/" class="generic_button large">Add Guide Category</a></li> 
				</ul><br>
				<?php if(count($categories) > 0) : ?>
				<div class="component-block"> 
				
					<table cellpadding="0" cellspacing="0"> 
						<tr class="lead"> 
							<th class="title">Name</th> 
							<th class="date">Created</th> 
							<th class="controls"></th> 
						</tr>
						<?php foreach($categories as $category) : ?> 
						<tr> 
							<td class="guide-info"> 
								<a href="/admin/guide_categories/edit/id/<?php echo $category->id; ?>/" class="guide-title"><?php echo $category->name; ?></a> 
								<span class="section"></span> 
							</td>
							<td class="date"><?php echo $category->created_at; ?></td> 
							<td class="controls-lists"> 
								<ul class="buttons">
									<li><a href="/admin/guide_categories/remove/id/<?php echo $category->id; ?>" class="delete">Delete</a></li> 
									<li><a href="/admin/guide_categories/edit/id/<?php echo $category->id; ?>" class="edit">Edit</a></li> 
								</ul> 
							</td> 
						</tr> 
						<?php endforeach; ?>
						</table> 
				</div>
				<?php else: ?>
				<p class="none">No categories found</p>
				<?php endif; ?>
			</div> 
