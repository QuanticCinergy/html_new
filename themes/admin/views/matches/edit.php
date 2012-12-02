<h1>Team Management</h1>
<div id="subnav"> 
	<ul> 
		<li><a href="/admin/squads/index/">Squads</a></li> 
		<li><a href="/admin/squad_categories/index/">Squad Categories</a></li> 
		<li class="active"><a href="/admin/matches/index/">Matches</a></li> 
	</ul> 
</div>
<div id="mainbody" class="with-subnav">
	<h2 class="form-head">Edit Match</h2>
	<?php echo partial('validation'); ?>
	<?php echo form_open('admin/matches/update'); ?>
	<?php echo form_hidden('id', $match->id); ?>
	<div class="form-row">
		<label>Squad</label>
		<?php echo form_dropdown('squad_id', $squads, $match->squad_id); ?>
	</div>
	<div class="form-row">
		<label>Opponent</label>
		<?php echo form_input('opponent', $match->opponent); ?>
	</div>
	<div class="form-row">
		<label>Starts At</label>
		<input type="text" name="starts_at" class="date">
	</div>
	<div class="form-row">
		<label>Tournament</label>
		<?php echo form_input('tournament', $match->tournament); ?>
	</div>
	<div class="form-row">
		<label>Description</label>
		<?php echo form_textarea('description', $match->description, 'class="short"'); ?>
	</div>
	<div class="form-row">
		<label>Score</label>
		<?php echo form_input('score', $match->score); ?>
	</div>
	<div class="form-row">
		<label>Opponent Score</label>
		<?php echo form_input('opponent_score', $match->opponent_score); ?>
	</div>
	<div class="form-row">
		<?php echo form_submit('submit', 'Update'); ?>
		<a href="/admin/teams/index/" class="cancel">Cancel</a>
	</div>
	</form>
</div>
