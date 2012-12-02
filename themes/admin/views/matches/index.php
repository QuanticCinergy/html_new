<h1>Team Management</h1>
<div id="subnav"> 
	<ul> 
		<li><a href="/admin/squads/index/">Squads</a></li> 
		<li><a href="/admin/squad_categories/index/">Squad Categories</a></li> 
		<li class="active"><a href="/admin/matches/index/">Matches</a></li> 
	</ul> 
</div>
			<div id="mainbody" class="with-subnav"> 
				<ul class="action-buttons"> 
					<li><a href="/admin/matches/add/" class="generic_button large">Add Match</a></li> 
				</ul><br>
				<?php if(count($matches) > 0) : ?>
				<div class="component-block"> 
				
					<table cellpadding="0" cellspacing="0"> 
						<tr class="lead">
							<th>VS</th>
							<th class="date">Starts At</th> 
							<th class="controls"></th> 
						</tr>
						<?php foreach($matches as $match) : ?> 
						<tr>
							<td><?php echo link_to($match->vs(), '/admin/matches/edit/id/'.$match->id); ?></td>
							<td class="date"><?php echo $match->starts_at; ?></td> 
							<td class="controls-lists"> 
								<ul class="buttons">
									<li><a href="/admin/matches/remove/id/<?php echo $match->id; ?>" class="delete">Delete</a></li> 
									<li><a href="/admin/matches/edit/id/<?php echo $match->id; ?>" class="edit">Edit</a></li> 
								</ul> 
							</td> 
						</tr> 
						<?php endforeach; ?>
						</table> 
				</div>
				<?php else: ?>
				<p class="none">No matches found.</p>
				<?php endif; ?>
			</div> 
