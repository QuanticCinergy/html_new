<h1>Guides</h1> 
			
			<div id="subnav"> 
				<ul> 
					<li class="active"><a href="/admin/guides/index/">Guides</a></li> 
					<li><a href="/admin/guide_sections/index/">Sections</a></li> 
					<li><a href="/admin/guide_categories/index/">Categories</a></li> 
				</ul> 
			</div> 
			
			<div id="mainbody" class="with-subnav"> 
				<ul class="action-buttons"> 
					<li><a href="/admin/guides/add/" class="generic_button large">Add Guide</a></li> 
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
					<form action="<?php echo site_url('/admin/guides/search'); ?>" method="get">
						<?php echo form_input('q', $this->input->get('q')); ?>
						<button type="submit" class="generic_button float-right medium">Search</button>
					</form>
				</div>
					
				</div> 
				
				<div class="component-block"> 
				
					<table cellpadding="0" cellspacing="0"> 
						<tr class="lead"> 
							<th class="title">Title</th> 
							<th class="category">Category</th> 
							<th class="author">Author</th> 
							<th class="date">Posted</th> 
							<th class="controls"></th> 
						</tr> 
						<?php foreach($guides as $guide) : ?>
						<tr> 
							<td class="guide-info"> 
								<a href="/admin/guides/edit/id/<?php echo $guide->id; ?>/" class="guide-title"><?php echo $guide->title; ?></a> 
								<span class="section"><?php echo $guide->section->name; ?></span> 
							</td> 
							<td><?php echo link_to($guide->category->name, '/admin/guides/index/category_id/'.$guide->category->id); ?></td> 
							<td><?php echo link_to($guide->user->full_name(), '/admin/users/show/id/'.$guide->user->id); ?></td> 
							<td class="date"><?php echo $guide->created_at; ?></td> 
							<td class="controls-lists"> 
								<ul class="buttons"> 
									<li><a href="/admin/guides/remove/id/<?php echo $guide->id; ?>" class="delete">Delete</a></li> 
									<li><a href="/admin/guides/edit/id/<?php echo $guide->id; ?>" class="edit">Edit</a></li> 
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
