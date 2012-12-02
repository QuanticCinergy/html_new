<h1>Team Management</h1>
<div id="subnav"> 
	<ul> 
		<li><a href="/admin/squads/index/">Squads</a></li> 
		<li><a href="/admin/squad_categories/index/">Squad Categories</a></li> 
		<li class="active"><a href="/admin/matches/index/">Matches</a></li> 
	</ul> 
</div>
<div id="mainbody" class="with-subnav">
	<h2 class="form-head">Add Match</h2>
	<?php echo partial('validation'); ?>
	<?php echo form_open('admin/matches/create'); ?>
	<div class="form-row">
		<label>Squad</label>
		<?php echo form_dropdown('squad_id', $squads); ?>
	</div>
	<div class="form-row">
		<label>Opponent</label>
		<?php echo form_input('opponent'); ?>
	</div>
	<div class="form-row">
		<label>Starts At</label>
		<input type="text" name="starts_at" class="date">
	</div>
	<div class="form-row">
		<label>Tournament</label>
		<?php echo form_input('tournament'); ?>
	</div>
	<div class="form-row">
		<label>Description</label>
		<?php echo form_textarea('description', '', 'class="short"'); ?>
	</div>
	<div class="form-row">
		<?php echo form_submit('submit', 'Create'); ?>
		<a href="/admin/teams/index/" class="cancel">Cancel</a>
	</div>
	</form>
</div>
