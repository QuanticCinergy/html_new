<h1>Edit Forum</h1>
<div id="subnav"> 
	<ul> 
		<li class="active"><a href="/admin/forums/index/">Forums</a></li>
		<li><a href="/admin/forum_threads/index/">Threads</a></li>
        <li><a href="/admin/forum_posts/index/">Posts</a></li>
		<li><a href="/admin/forum_sections/index/">Sections</a></li>
	</ul> 
</div> 
	
<div id="mainbody" class="with-subnav"> 
<h2 class="form-head">Edit Forum</h2>
<?php echo partial('validation'); ?>
<?php echo form_open_multipart('admin/forums/update'); ?>
<?php echo form_hidden('id', $forum->id); ?>
<div class="form-row">
	<label>Name</label>
	<?php echo form_input('name', $forum->name); ?>
</div>
<div class="form-row">
	<label>Section</label>
	<?php echo form_dropdown('section_id', $sections, $forum->section_id); ?>
</div>
<div class="form-row">
	<label>Description</label>
	<?php echo form_textarea('description', $forum->description, 'class="short"'); ?>
</div>
<?php echo img($forum->icon_thumb_url); ?><br>
<div class="form-row">
	<label>Icon</label>
	<?php echo form_upload('icon'); ?>
	</div>
<div class="form-row">
	<?php echo form_submit('submit', 'Update'); ?>
	<a href="/admin/forums/index/" class="cancel">Cancel</a>
</div>
</form>
</div>
