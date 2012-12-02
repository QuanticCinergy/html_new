<h1>Videos</h1> 
			
			<div id="subnav"> 
				<ul> 
					<li><a href="/admin/galleries/index/">Galleries</a></li> 
					<li class="active"><a href="/admin/videos/index/">Videos</a></li>
					<li><a href="/admin/video_categories/index/">Video Categories</a></li> 
				</ul> 
			</div> 
			
			<div id="mainbody" class="with-subnav"> 
				<ul class="action-buttons"> 
					<li><a href="/admin/videos/add/" class="generic_button large">Add Video</a></li> 
				</ul> 
				
				<?php if(count($videos) > 0) : ?>
				
				<div class="component-block"> 
				
					<table cellpadding="0" cellspacing="0"> 
						<tr class="lead"> 
							<th class="title">Title</th> 
							<th class="category">Category</th> 
							<th class="author">Author</th> 
							<th class="date">Posted</th> 
							<th class="controls"></th> 
						</tr> 
						<?php foreach($videos as $video) : ?>
						<tr> 
							<td class="article-info"> 
								<a href="/admin/videos/show/id/<?php echo $video->id; ?>/" class="article-title"><?php echo $video->title; ?></a> 
							</td> 
							<td><?php echo link_to($video->category->name, '/admin/videos/index/category_id/'.$video->category->id); ?></td> 
							<td><?php echo link_to($video->user->full_name(), '/admin/users/show/id/'.$video->user->id); ?></td> 
							<td class="date"><?php echo $video->created_at; ?></td> 
							<td class="controls-lists"> 
								<ul class="buttons"> 
									<li><a href="/admin/videos/remove/id/<?php echo $video->id; ?>" class="delete">Delete</a></li> 
									<li><a href="/admin/videos/edit/id/<?php echo $video->id; ?>" class="edit">Edit</a></li> 
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
				<br /><p class="none">No videos found</p>
				<?php endif; ?>
			
			</div> 
