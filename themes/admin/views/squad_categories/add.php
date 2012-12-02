<h1>Squad Categories</h1>

<div id="subnav"> 
	<ul> 
		<li><a href="/admin/squads/index/">Squads</a></li> 
		<li class="active"><a href="/admin/squad_categories/index/">Squad Categories</a></li> 
		<li><a href="/admin/matches/index/">Matches</a></li> 
	</ul> 
</div> 

<div id="mainbody" class="with-subnav">
	<h2 class="form-head">Add New Category</h2>
	<p class="tip">Categories are holding groups for squads. Professional or Community for example.</p>
	<?php echo partial('validation'); ?>
	<?php echo form_open('admin/squad_categories/create'); ?>
	<div class="form-row">
		<label>Category Name</label>
		<?php echo form_input('name'); ?>
	</div>
	<div class="form-row">
		<?php echo form_submit('submit', 'Create'); ?>
		<a href="/admin/squad_categories/index/" class="cancel">Cancel</a>
	</div>
	</form>
</div>