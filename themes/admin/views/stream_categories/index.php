<h1>Stream Categories</h1>
<div id="subnav"> 
	<ul> 
		<li><a href="/admin/streams/index/">Streams</a></li> 
		<li><a href="/admin/stream_sections/index/">Classifications</a></li> 
		<li class="active"><a href="/admin/stream_categories/index/">Games</a></li>
	</ul> 
</div> 
			
			<div id="mainbody" class="with-subnav"> 
				<ul class="action-buttons"> 
					<li><a href="/admin/stream_categories/add/" class="generic_button large">Add Stream Game</a></li> 
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
							<td class="stream-info"> 
								<a href="/admin/stream_categories/edit/id/<?php echo $category->id; ?>/" class="stream-title"><?php echo $category->name; ?></a> 
								<span class="section"></span> 
							</td>
							<td class="date"><?php echo $category->created_at; ?></td> 
							<td class="controls-lists"> 
								<ul class="buttons">
									<li><a href="/admin/stream_categories/remove/id/<?php echo $category->id; ?>" class="delete">Delete</a></li> 
									<li><a href="/admin/stream_categories/edit/id/<?php echo $category->id; ?>" class="edit">Edit</a></li> 
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
