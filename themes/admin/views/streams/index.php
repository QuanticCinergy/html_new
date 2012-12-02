<h1>Streams</h1> 
			
			<div id="subnav"> 
				<ul> 
					<li class="active"><a href="/admin/streams/index/">Streams</a></li> 
		<li><a href="/admin/stream_sections/index/">Classifications</a></li> 
		<li><a href="/admin/stream_categories/index/">Games</a></li>
				</ul> 
			</div> 
			
			<div id="mainbody" class="with-subnav"> 
				<ul class="action-buttons"> 
					<li><a href="/admin/streams/add/" class="generic_button large">Add Stream</a></li> 
				</ul> 
				
				<div class="filterby component-block"> 
				
				<h3>Filter List By</h3>
				
					<?php
						if((int)current_user()->group_id !== 3):
							echo form_dropdown('user_id', $users, param('user_id'));
						endif;
						
						echo form_dropdown('section_id', $sections, param('section_id')); 
						echo form_dropdown('category_id', $categories, param('category_id'));
						
						if((int)current_user()->group_id !== 3):
							echo form_dropdown('status', array(
								'draft' => 'Draft',	
								'published' => 'Published'
							), param('status') ? param('status') : 'published');
						endif;
					?>
					
				<div class="search-block">
					<form action="<?php echo site_url('/admin/streams/search'); ?>" method="get">
						<?php echo form_input('q', $this->input->get('q')); ?>
						<button type="submit" class="generic_button float-right medium">Search</button>
					</form>
				</div>
					
				</div> 
				
				<div class="component-block"> 
				
					<table cellpadding="0" cellspacing="0"> 
						<tr class="lead"> 
							<th class="title">Streamer</th> 
							<th class="category">Classification</th> 
							<th class="author">Game</th> 
							<th class="controls"></th> 
						</tr> 
						<?php foreach($streams as $stream) : ?>
						<tr> 
							<td class="stream-info"> 
								<a href="/admin/streams/edit/id/<?php echo $stream->id; ?>/" class="stream-title"><?php echo $stream->title; ?></a> 
							</td> 
							<td><?php echo $stream->section->name; ?></td> 
							<td><?php echo link_to($stream->category->name, '/admin/streams/index/category_id/'.$stream->category->id); ?></td> 

							<td class="controls-lists"> 
								<ul class="buttons"> 
									<li><a href="/admin/streams/remove/id/<?php echo $stream->id; ?>" class="delete">Delete</a></li> 
									<li><a href="/admin/streams/edit/id/<?php echo $stream->id; ?>" class="edit">Edit</a></li> 
								</ul> 
							</td> 
						</tr> 
						<?php endforeach; ?>
					</table> 
					
					<div class="pagination">
						<?php echo $pagination; ?>
					</div>
				
				</div> 
			
			</div> 
