<h1>Video Categories</h1>

<div id="subnav"> 
	<ul> 
		<li><a href="/admin/galleries/index/">Galleries</a></li> 
		<li><a href="/admin/videos/index/">Videos</a></li> 
		<li class="active"><a href="/admin/video_categories/index/">Video Categories</a></li> 

	</ul> 
</div> 

<div id="mainbody" class="with-subnav">
	<h2>Add New Category</h2>
	<?php echo partial('validation'); ?>
	<?php echo form_open('admin/video_categories/create'); ?>
	<div class="form-row">
		<label>Category Name</label>
		<?php echo form_input('name'); ?>
	</div>
	<div class="form-row">
		<?php echo form_submit('submit', 'Create'); ?>
		<a href="/admin/video_categories/index/" class="cancel">Cancel</a>
	</div>
	</form>
</div>
