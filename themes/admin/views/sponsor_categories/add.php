<h1>Sponsor Categories</h1>

<div id="subnav"> 
	<ul> 
		<li><a href="/admin/sponsors/index/">Sponsors</a></li> 
		<li class="active"><a href="/admin/sponsor_categories/index/">Categories</a></li> 
	</ul>
</div> 

<div id="mainbody" class="with-subnav">
	<h2 class="form-head">Add Category</h2>
	<?php echo partial('validation'); ?>
	<?php echo form_open('admin/sponsor_categories/create'); ?>
	<div class="form-row">
		<label>Category Name</label>
		<?php echo form_input('name'); ?>
	</div>
	<div class="form-row">
		<?php echo form_submit('submit', 'Create'); ?>
		<a href="/admin/sponsor_categories/index/" class="cancel">Cancel</a>
	</div>
	</form>
</div>
