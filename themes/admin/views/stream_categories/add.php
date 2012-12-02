<h1>Stream Categories</h1>

<div id="subnav"> 
	<ul> 
		<li><a href="/admin/streams/index/">Streams</a></li> 
		<li><a href="/admin/stream_sections/index/">Classifications</a></li> 
		<li class="active"><a href="/admin/stream_categories/index/">Games</a></li> 
	</ul> 
</div> 

<div id="mainbody" class="with-subnav">
	<h2 class="form-head">Add Stream Game</h2>
	<p class="tip">These are games that the player would generally stream</p>
	<?php echo partial('validation'); ?>
	<?php echo form_open('admin/stream_categories/create'); ?>
	<div class="form-row">
		<label>Game Name</label>
		<?php echo form_input('name'); ?>
	</div>
	<div class="form-row">
		<?php echo form_submit('submit', 'Create'); ?>
		<a href="/admin/stream_categories/index/" class="cancel">Cancel</a>
	</div>
	</form>
</div>