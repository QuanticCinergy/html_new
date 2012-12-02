<h1>Sponsors</h1>

<div id="subnav"> 
	<ul> 
		<li class="active"><a href="/admin/sponsors/index/">Sponsors</a></li>
		<li><a href="/admin/sponsor_categories/index/">Categories</a></li> 
	</ul> 
</div> 

<div id="mainbody" class="with-subnav">
	<h2 class="form-head">Edit Sponsor</h2>
	<?php echo partial('validation'); ?>
	<?php echo form_open_multipart('admin/sponsors/update'); ?>
	<?php echo form_hidden('id', $sponsor->id); ?>
	<div class="form-row">
		<label>Name</label>
		<?php echo form_input('name', $sponsor->name); ?>
	</div>
	<div class="form-row">
		<label>Description</label>
		<?php echo form_textarea('description', $sponsor->description, 'class="short"'); ?>
	</div>
	<div class="form-row">
		<label>Category</label>
		<?php echo form_dropdown('category_id', $categories, $sponsor->category_id); ?>
	</div>
	<div class="form-row">
		<label>Logo</label>
		<?php echo img($sponsor->logo_thumb_url); ?> <br /><br />
		<?php echo form_upload('logo'); ?>	
	</div>
	<div class="form-row">
		<?php echo form_submit('submit', 'Update'); ?>
		<a href="/admin/sponsors/index/" class="cancel">Cancel</a>
	</div>
	</form>
</div>
