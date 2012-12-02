<h1>Advertisement Slots</h1>
<div id="subnav"> 
				<ul> 
					<li><a href="/admin/ads/index/">Advertisements</a></li> 
					<li class="active"><a href="/admin/ad_slots/index/">Slots</a></li> 
				</ul> 
			</div>

<div id="mainbody" class="with-subnav">
	<h2 class="form-head">Edit Slot</h2>
	<?php echo partial('validation'); ?>
	<?php echo form_open('admin/ad_slots/update'); ?>
	<?php echo form_hidden('id', $slot->id); ?>
	<div class="form-row">
		<label>Name</label>
		<?php echo form_input('name', humanize($slot->name)); ?>
	</div>
	<div class="form-row">
		<label>Image Width</label>
		<?php echo form_input('image_width', $slot->image_width); ?>
	</div>
	<div class="form-row">
		<label>Image Height</label>
		<?php echo form_input('image_height', $slot->image_height); ?>
	</div>
	<div class="form-row">
		<?php echo form_submit('submit', 'Update'); ?>
		<a href="/admin/ad_slots/index/" class="cancel">Cancel</a>
	</div>
	</form>
</div>
