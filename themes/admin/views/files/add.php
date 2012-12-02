<h1>Files & Downloads</h1>

<div id="subnav"> 
	<ul> 
		<li class="active"><a href="/admin/files/index/">Files</a></li>
		<li><a href="/admin/file_categories/index/">Categories</a></li> 
	</ul> 
</div> 
			
<div id="mainbody" class="with-subnav"> 
	<h2 class="form-head">Upload New File</h2>
	<?php partial('validation'); ?>
	<?php echo form_open_multipart('admin/files/create'); ?>
		<div class="form-row">
			<label>Name</label>
			<?php echo form_input('name'); ?>
		</div>
		<div class="form-row">
			<label>Description</label>
			<?php echo form_textarea('description', '', 'class="short"'); ?>
		</div>
		<div class="form-row">
			<label>Category</label>
			<?php echo form_dropdown('category_id', $categories); ?>
		</div>
		<div class="form-row">
			<label>File</label>
			<?php echo form_upload('file'); ?>
		</div>
		<div class="form-row">
			<?php echo form_submit('submit', 'Upload'); ?>
			<a href="/admin/files/index/" class="cancel">Cancel</a>
		</div>
	</form>
</div>
