<h1>Stream Sections</h1>
<div id="subnav"> 
	<ul> 
		<li><a href="/admin/streams/index/">Streams</a></li> 
		<li class="active"><a href="/admin/stream_sections/index/">Classifications</a></li> 
		<li><a href="/admin/stream_categories/index/">Games</a></li> 
	</ul> 
</div> 

<div id="mainbody" class="with-subnav"> 
	<h2 class="form-head">Add Stream Classification</h2>
	<p class="tip">This is where the streamer belongs, e.g. featured or general public user.</p>
	<?php echo partial('validation'); ?>
	<?php echo form_open('admin/stream_sections/create'); ?>
	<div class="form-row">
		<label>Classification Name</label>
		<?php echo form_input('name'); ?>
	</div>
	<div class="form-row">
		<?php echo form_submit('submit', 'Create'); ?>
		<a href="/admin/stream_sections/index/" class="cancel">Cancel</a>
	</div>
	</form>
</div>
