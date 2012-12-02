<h1>Guide Sections</h1>
<div id="subnav"> 
	<ul> 
		<li><a href="/admin/guides/index/">Guides</a></li> 
		<li class="active"><a href="/admin/guide_sections/index/">Sections</a></li> 
		<li><a href="/admin/guide_categories/index/">Categories</a></li> 
	</ul> 
</div> 

<div id="mainbody" class="with-subnav"> 
	<h2 class="form-head">Add Guide Section</h2>
	<p class="tip">Guide sections are mutually exclusive from each other but they share categories. These are generally games.</p>
	<?php echo partial('validation'); ?>
	<?php echo form_open('admin/guide_sections/create'); ?>
	<div class="form-row">
		<label>Section Name</label>
		<?php echo form_input('name'); ?>
	</div>
	<div class="form-row">
		<?php echo form_submit('submit', 'Create'); ?>
		<a href="/admin/guide_sections/index/" class="cancel">Cancel</a>
	</div>
	</form>
</div>
