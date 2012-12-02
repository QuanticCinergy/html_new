<h1>Sponsors</h1>

<div id="subnav"> 
	<ul> 
		<li class="active"><a href="/admin/sponsors/index/">Sponsors</a></li>
		<li><a href="/admin/sponsor_categories/index/">Categories</a></li> 
	</ul> 
</div> 

<div id="mainbody" class="with-subnav">
	<h2 class="form-head">Add Sponsor</h2>
	<?php echo partial('validation'); ?>
	<?php echo form_open_multipart('admin/sponsors/create'); ?>
	<div class="form-row">
		<label>Name</label>
		<?php echo form_input('name'); ?>
	</div>
	<div class="form-row">
		<label>Description</label>
		<?php echo form_textarea('description', '', 'class="short"'); ?>
	</div>
	<div class="form-row">
		<label>Logo</label>
		<?php echo form_upload('logo'); ?>
	</div>
	<div class="form-row">
		<label>Category</label>
		<?php echo form_dropdown('category_id', $categories); ?>
	</div>
	<div class="form-row">
		<?php echo form_submit('submit', 'Create'); ?>
		<a href="/admin/sponsors/index/" class="cancel">Cancel</a>
	</div>
	</form>
</div>
