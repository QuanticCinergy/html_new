<h1>Files & Downloads</h1> 
			
			<div id="subnav"> 
				<ul> 
					<li class="active"><a href="/admin/files/index/">Files</a></li>
					<li><a href="/admin/file_categories/index/">Categories</a></li> 
				</ul> 
			</div> 
			
			<div id="mainbody" class="with-subnav"> 
				<ul class="action-buttons"> 
					<li><a href="/admin/files/add/" class="generic_button large">Upload File</a></li> 
				</ul>
				<br>
				
				<?php if(count($files) > 0) : ?>
				<div class="component-block"> 
				
					<table cellpadding="0" cellspacing="0"> 
						<tr class="lead"> 
							<th class="title">Name</th> 
							<th class="category">Category</th> 
							<th>User</th> 
							<th class="date">Uploaded</th> 
							<th class="controls"></th> 
						</tr> 
						<?php foreach($files as $file) : ?>
						<tr> 
							<td> 
								<a href="/admin/files/edit/id/<?php echo $file->id; ?>/"><?php echo $file->name; ?></a> 
							</td> 
							<td><?php echo link_to($file->category->name, '/admin/files/index/category_id/'.$file->category->id); ?></td> 
							<td><?php echo link_to($file->user->full_name(), '/admin/users/edit/id/'.$file->user->id); ?></td> 
							<td class="date"><?php echo $file->created_at; ?></td> 
							<td class="controls-lists"> 
								<ul class="buttons">
									 
									<li><a href="/admin/files/remove/id/<?php echo $file->id; ?>" class="delete">Delete</a></li> 
									<li><a href="/admin/files/edit/id/<?php echo $file->id; ?>" class="edit">Edit</a></li>
								</ul> 
							</td> 
						</tr> 
						<?php endforeach; ?>
					</table> 
					
					<div class="pagination">
						<?php echo $pagination; ?>
					</div>
				
				</div> 
				
				<?php else: ?>
					<p class="none">No files found</p>
				<?php endif; ?>
			
			</div> 
