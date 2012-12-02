<h1>Team Management</h1>
<div id="subnav"> 
	<ul> 
		<li class="active"><a href="/admin/squads/index/">Squads</a></li> 
		<li><a href="/admin/squad_categories/index/">Squad Categories</a></li> 
		<li><a href="/admin/matches/index/">Matches</a></li> 
	</ul> 
</div>
<div id="mainbody" class="with-subnav">
	<h2 class="form-head">Add Squad</h2>
	<?php echo partial('validation'); ?>
	<?php echo form_open_multipart('admin/squads/create'); ?>
	<div class="form-row">
		<label>Squad Name</label>
		<?php echo form_input('name'); ?>
	</div>
	
	<div class="form-row">
		<label>Category</label>
		<?php echo form_dropdown('category_id', $categories); ?>
	</div>
	
	<div class="form-row">
		<label>Description</label>
		<?php echo form_textarea('description', '', 'class="short"'); ?>
	</div>
	
	<div class="form-row">
		<label>Gaming Gear</label>
		<?php echo form_textarea('gaming_gear', '', 'class="full"'); ?>
	</div>
	
	<div class="form-row">
		<label>Squad Banner</label>
		<?php echo form_upload('image'); ?>
	</div>
	
	<div class="form-row">
		<label>Members</label>
		<input type="text" name="members" class="users-tokeninput">
		<br /><br />
	</div>
	<div class="form-row">
		<?php echo form_submit('submit', 'Create'); ?>
		<a href="/admin/teams/index/" class="cancel">Cancel</a>
	</div>
	</form>
</div>
