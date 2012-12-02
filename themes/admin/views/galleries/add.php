<h1>Galleries</h1>

<div id="subnav"> 
	<ul> 
		<li class="active"><a href="/admin/galleries/index/">Galleries</a></li> 
		<li><a href="/admin/videos/index/">Videos</a></li> 
		<li><a href="/admin/video_categories/index/">Video Categories</a></li> 
	</ul> 
</div> 


<div id="mainbody" class="with-subnav">
	<h2 class="form-head">Add New Gallery</h2>
	<?php echo partial('validation'); ?>
	<?php echo form_open_multipart('admin/galleries/create'); ?>
		
		<div class="form-row">
			<label>Title</label>
			<?php echo form_input('title'); ?>
		</div>
		<div class="form-row">
			<label>Short Description</label>
			<?php echo form_textarea('short_description', '', 'class="short"'); ?>
		</div>
		<div class="form-row">
			<label>Description<label>
			<?php echo form_textarea('description', '', 'class="full"'); ?>
		</div>
		<div class="form-row">
			<label>Photos</label>
			<i>You will be able to upload photos just after you create a new gallery.</i>
			<!--<input type="file" multiple accept="image/*" name="photos[]">-->
		</div>
		<div class="form-row">
			<?php echo form_submit('submit', 'Create'); ?>
			<a href="/admin/galleries/index/" class="cancel">Cancel</a>
		</div>
	</form>
</div>

