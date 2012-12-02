<h1>Galleries</h1> 
<div id="subnav"> 
	<ul> 
		<li class="active"><a href="/admin/galleries/index/">Galleries</a></li> 
		<li><a href="/admin/videos/index/">Videos</a></li> 
		<li><a href="/admin/video_categories/index/">Video Categories</a></li> 
	</ul> 
</div> 


<div id="mainbody" class="with-subnav">
				<ul class="action-buttons"> 
					<li><a href="/admin/galleries/add/" class="generic_button large">Add Gallery</a></li> 
				</ul>
				
				
				<?php if(count($galleries) > 0) : ?>
				
				<div class="component-block"> 
				
					<table cellpadding="0" cellspacing="0" class="gallery"> 
						<tr class="lead">
							<th>Cover</th>
							<th>Gallery</th>
							<th>Controls</th>
						</tr>
						
						<?php foreach($galleries as $gallery) : ?>
						<tr> 
							<td>
								<?php
									if($gallery->cover_id) {
										$photo = new Photo($gallery->cover_id);
										echo img($photo->photo_thumb_url);
										unset($photo);
									}
								?>
							</td>
							<td> 
								<h3><a href="/admin/galleries/edit/id/<?php echo $gallery->id; ?>/"><?php echo $gallery->title; ?></a></h3>
								<ul>
								<?php foreach($gallery->limit(5)->photos as $photo) : ?>
									<li><?php echo link_to(img($photo->photo_thumb_url), '/admin/photos/edit/id/'.$photo->id); ?></li>
								<?php endforeach; ?>
								</ul>
							</td>
							<td class="controls-lists"> 
								<ul class="buttons"> 
									<li><a href="/admin/galleries/remove/id/<?php echo $gallery->id; ?>" class="delete">Delete</a></li> 
									<li><a href="/admin/galleries/edit/id/<?php echo $gallery->id; ?>" class="edit">Edit</a></li> 
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
				<p class="none">No galleries found</p>
				<?php endif; ?>
			
			</div> 
