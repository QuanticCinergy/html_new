<h1>Video Categories</h1>
<div id="subnav"> 
				<ul> 
					<li><a href="/admin/galleries/index/">Galleries</a></li> 
					<li><a href="/admin/videos/index/">Videos</a></li> 
					<li class="active"><a href="/admin/video_categories/index/">Video Categories</a></li> 
				</ul> 
			</div> 
			
			<div id="mainbody" class="with-subnav"> 
				<ul class="action-buttons"> 
					<li><a href="/admin/video_categories/add/" class="generic_button large">Add Category</a></li> 
				</ul>
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
							<td> 
								<a href="/admin/video_categories/edit/id/<?php echo $category->id; ?>/" class="article-title"><?php echo $category->name; ?></a>  
							</td>
							<td class="date"><?php echo $category->created_at; ?></td> 
							<td class="controls-lists"> 
								<ul class="buttons">
									<li><a href="/admin/video_categories/remove/id/<?php echo $category->id; ?>" class="delete">Delete</a></li> 
									<li><a href="/admin/video_categories/edit/id/<?php echo $category->id; ?>" class="edit">Edit</a></li> 
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
