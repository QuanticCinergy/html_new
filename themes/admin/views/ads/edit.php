<h1>Advertisements</h1>

<div id="subnav"> 
	<ul> 
		<li class="active"><a href="/admin/ads/index/">Advertisements</a></li> 
		<li><a href="/admin/ad_slots/index/">Slots</a></li>  
	</ul> 
</div> 

<div id="mainbody" class="with-subnav">
	<h2 class="form-head">Edit Advertisement</h2>
	<?php echo partial('validation'); ?>
	<?php echo form_open_multipart('admin/ads/update'); ?>
	<?php echo form_hidden('id', $ad->id); ?>
	<div class="form-row">
		<label>Name</label>
		<?php echo form_input('name', $ad->name); ?>
	</div>
	<div class="form-row">
		<label>Views Limit</label>
		<?php echo form_input('views_limit', (int) $ad->views_limit); ?>
	</div>
	<div class="form-row">
		<label>URL</label>
		<?php echo form_input('url', $ad->url); ?>
	</div>
	<div class="form-row">
		<label>Image</label>
		<?php echo img($ad->image_thumb_url); ?>
		<br /><br />
		<?php echo form_upload('image'); ?>
	</div>
	<h2>OR</h2>
	<div class="form-row">
		<label>Embed Code</label>
		<?php echo form_textarea('embed_code', $ad->embed_code); ?>
	</div>
	<br /><br />
	<div class="form-row">
		<label>Slot</label>
		<?php echo form_dropdown('slot_id', $slots, $ad->slot_id); ?>
	</div>
	<div class="form-row">
		<?php echo form_submit('submit', 'Update'); ?>
		<a href="/admin/ads/index/" class="cancel">Cancel</a>
	</div>
	</form>
</div>
