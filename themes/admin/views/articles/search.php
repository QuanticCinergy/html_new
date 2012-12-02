<h1>Articles</h1> 
			
			<div id="subnav"> 
				<ul> 
						<li class="active"><a href="/admin/articles/index/">Articles</a></li> 
						<li><a href="/admin/article_sections/index/">Sections</a></li> 
						<li><a href="/admin/article_categories/index/">Categories</a></li>

				</ul> 
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
					
				</div> 
				
				<div class="component-block"> 
				
					<table cellpadding="0" cellspacing="0"> 
						<tr class="lead"> 
							<th class="title">Title</th>
							<th class="author">Author</th> 
							<th class="date">Posted</th> 
							<th class="controls"></th> 
						</tr> 
						<?php foreach($result as $row) : ?>
						<tr> 
							<td class="article-info"> 
								<a href="/admin/articles/edit/id/<?php echo $row['id']; ?>/" class="article-title"><?php echo $row['title']; ?></a> 
							</td>
							<td><?php echo link_to($row['username'], '/admin/users/edit/id/'.$row['user_id']); ?></td> 
							<td class="date"><?php echo unix_to_human($row['created_at']); ?></td> 
							<td class="controls-lists"> 
								<ul class="buttons"> 
									<li><a href="/admin/articles/remove/id/<?php echo $row['id']; ?>" class="delete">Delete</a></li> 
									<li><a href="/admin/articles/edit/id/<?php echo $row['id']; ?>" class="edit">Edit</a></li> 
								</ul> 
							</td> 
						</tr> 
						<?php endforeach; ?>
					</table> 
				
				</div> 
			
			</div> 
