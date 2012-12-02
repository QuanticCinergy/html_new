<h1>Articles</h1> 
			
			<div id="subnav"> 
				<ul> 
						<li class="active"><a href="/admin/articles/index/">Articles</a></li> 
						<li><a href="/admin/article_sections/index/">Sections</a></li> 
						<li><a href="/admin/article_categories/index/">Categories</a></li>				</ul> 
			</div>  
			
			<div id="mainbody" class="with-subnav"> 
				<ul class="action-buttons"> 
					<li><a href="/admin/articles/add/" class="generic_button large">Add Article</a></li> 
				</ul>
				
				<div class="filterby component-block" style="display:block"> 
				
				<h3>Filter List By</h3>
				
				<?php echo form_open('admin/articles/search'); ?>
				
				<div id="search"><?php echo form_input('q'); ?>
				
				<?php echo form_submit('submit', 'Search'); ?></div>

				</form>
				
				<br>
				
					<?php 
					echo form_dropdown('user_id', $users, param('user_id'), 'class="filter"');
					echo form_dropdown('section_id', $sections, param('section_id'), 'class="filter"'); 
					echo form_dropdown('category_id', $categories, param('category_id'), 'class="filter"');
					echo form_dropdown('status', array(
						'-1'        => 'Status',
						'draft'     => 'Draft',
						'published' => 'Published'
					), param('status'), 'class="filter"');
					?>
					
				</div> 
				
				<div class="component-block"> 
				
					<table cellpadding="0" cellspacing="0"> 
						<tr class="lead"> 
							<th class="title">Title</th>
							<th class="author">Author</th> 
							<th class="date">Posted</th> 
							<th class="controls"></th> 
						</tr> 
						<?php foreach($articles as $article) : ?>
						<tr> 
							<td class="article-info"> 
								<a href="/admin/articles/edit/id/<?php echo $article->id; ?>/" class="article-title"><?php echo $article->title; ?></a> 
								<span class="section"><?php echo $article->section->name; ?></span> 
							</td>
							<td><?php echo link_to($article->user->full_name(), '/admin/users/show/id/'.$article->user->id); ?></td> 
							<td class="date"><?php echo $article->created_at; ?></td> 
							<td class="controls-lists"> 
								<ul class="buttons"> 
									<li><a href="/admin/articles/remove/id/<?php echo $article->id; ?>" class="delete">Delete</a></li> 
									<li><a href="/admin/articles/edit/id/<?php echo $article->id; ?>" class="edit">Edit</a></li> 
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
