<h1>Guide Categories</h1>

<div id="subnav"> 
	<ul> 
		<li><a href="/admin/guides/index/">Guides</a></li> 
		<li><a href="/admin/guide_sections/index/">Sections</a></li> 
		<li class="active"><a href="/admin/guide_categories/index/">Categories</a></li> 
	</ul> 
</div> 

<div id="mainbody" class="with-subnav">
	<h2 class="form-head">Add Guide Category</h2>
	<p class="tip">Categories are usually descriptive of the subject of the guide.</p>
	<?php echo partial('validation'); ?>
	<?php echo form_open('admin/guide_categories/create'); ?>
	<div class="form-row">
		<label>Category Name</label>
		<?php echo form_input('name'); ?>
	</div>
	<div class="form-row">
		<?php echo form_submit('submit', 'Create'); ?>
		<a href="/admin/guide_categories/index/" class="cancel">Cancel</a>
	</div>
	</form>
</div>