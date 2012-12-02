<h1>Stream Categories</h1>

<div id="subnav"> 
	<ul> 
		<li><a href="/admin/streams/index/">Streams</a></li> 
		<li><a href="/admin/stream_sections/index/">Classifications</a></li> 
		<li class="active"><a href="/admin/stream_categories/index/">Games</a></li>
	</ul> 
</div> 

<div id="mainbody" class="with-subnav">
	<h2 class="form-head">Edit Game</h2>
	<?php echo partial('validation'); ?>
	<?php echo form_open('admin/stream_categories/update'); ?>
	<?php echo form_hidden('id', $category->id); ?>
	<div class="form-row">
		<label>Game name</label>
		<?php echo form_input('name', $category->name); ?>
	</div>
	<div class="form-row">
		<?php echo form_submit('submit', 'Update'); ?>
		<a href="/admin/stream_categories/index/" class="cancel">Cancel</a>
	</div>
	</form>
</div>
