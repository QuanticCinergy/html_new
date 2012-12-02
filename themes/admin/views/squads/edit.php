<h1>Team Management</h1>
<div id="subnav"> 
	<ul> 
		<li class="active"><a href="/admin/squads/index/">Squads</a></li> 
		<li><a href="/admin/squad_categories/index/">Squad Categories</a></li> 
		<li><a href="/admin/matches/index/">Matches</a></li> 
	</ul> 
</div> 

<div id="mainbody" class="with-subnav">
	<h2 class="form-head">Edit Squad</h2>
	<?php echo partial('validation'); ?>
	<?php echo form_open_multipart('admin/squads/update'); ?>
	<?php echo form_hidden('id', $squad->id); ?>
	<div class="form-row">
		<label>Squad Name</label>
		<?php echo form_input('name', $squad->name); ?>
	</div>
	
	<div class="form-row">
		<label>Category</label>
		<?php echo form_dropdown('category_id', $categories, $squad->category_id); ?>
	</div>
	
	<div class="form-row">
		<label>Description</label>
		<?php echo form_textarea('description', $squad->description, 'class="short"'); ?>
	</div>
	
	<div class="form-row">
		<label>Gaming Gear</label>
		<?php echo form_textarea('gaming_gear', $squad->gaming_gear, 'class="full"'); ?>
	</div>
	
	<div class="form-row">
		<label>Squad Banner</label>
		<?php echo img($squad->image_url); ?>
		<?php echo form_upload('image'); ?>
	</div>	
	
	<div class="form-row">
		<label>Members</label>
		<script>window.onload = function(){pop('<?php echo $members_json; ?>');}</script>
		<input type="text" name="members" class="users-tokeninput">
		<br /><br />
	</div>
	
	<div class="form-row">
		<?php echo form_submit('submit', 'Update'); ?>
		<a href="/admin/squads" class="cancel">Cancel</a>
	</div>
	</form>
</div>
