<h1>Stream Sections</h1>
<div id="subnav"> 
	<ul> 
				<li><a href="/admin/streams/index/">Streams</a></li> 
		<li class="active"><a href="/admin/stream_sections/index/">Classifications</a></li> 
		<li><a href="/admin/stream_categories/index/">Games</a></li> 
	</ul> 
</div> 
			
			<div id="mainbody" class="with-subnav"> 
				<ul class="action-buttons"> 
					<li><a href="/admin/stream_sections/add/" class="generic_button large">Add Stream Classification</a></li> 
				</ul>
				<br />
				<div class="component-block"> 
				
					<table cellpadding="0" cellspacing="0"> 
						<tr class="lead"> 
							<th class="title">Name</th>
							<th class="date">Created</th> 
							<th class="controls"></th> 
						</tr>
						<?php foreach($sections as $section) : ?> 
						<tr> 
							<td class="stream-info"> 
								<a href="/admin/stream_sections/edit/id/<?php echo $section->id; ?>/" class="stream-title"><?php echo $section->name; ?></a> 
								<span class="section"></span> 
							</td>
							<td class="date"><?php echo $section->created_at; ?></td> 
							<td class="controls-lists"> 
								<ul class="buttons">
									<li><a href="/admin/stream_sections/remove/id/<?php echo $section->id; ?>" class="delete">Delete</a></li> 
									<li><a href="/admin/stream_sections/edit/id/<?php echo $section->id; ?>" class="edit">Edit</a></li> 
								</ul> 
							</td> 
						</tr> 
						<?php endforeach; ?>
					</table> 
				</div>
			</div> 
