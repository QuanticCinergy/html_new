<h1>Streams</h1>

<div id="subnav"> 
	<ul> 
		<li class="active"><a href="/admin/streams/index/">Streams</a></li> 
		<li><a href="/admin/stream_sections/index/">Classifications</a></li> 
		<li><a href="/admin/stream_categories/index/">Games</a></li>
	</ul> 
</div> 

<div id="mainbody" class="with-subnav">
	

	<?php echo partial('validation'); ?>
	<?php echo form_open_multipart('admin/streams/update'); ?>
	<?php echo form_hidden('id', param('id')); ?>
			<script>
			$(function() {

    var $sidebar   = $("#form-final"),
        $window    = $(window),
        offset     = $sidebar.offset(),
        topPadding = 15;

    $window.scroll(function() {
        if ($window.scrollTop() > offset.top) {
            $sidebar.stop().animate({
                marginTop: $window.scrollTop() - offset.top + topPadding
            });
        } else {
            $sidebar.stop().animate({
                marginTop: 0
            });
        }
    });

});
		</script>
		<div id="form-final">
			<div class="final-row">
				<label>Stream Lead Image</label>
				
				<?php if(strlen($stream->image_url) > 0): ?>
					<?php echo img($stream->image_url); ?>
				<?php endif; ?>
				
				<?php echo form_upload('image'); ?>
			</div>	
			<div class="final-row">
				<label>Date (click to change) </label>
				<input type="text" value="<?= date('d-m-Y G:i', $stream->original_created_at) ?>" name="created_at" class="date" />
			</div>
			
			<?php if((int)current_user()->group_id !== 3): ?>
				<div class="final-row">
					<label>Publish Status</label>
					<?php echo form_dropdown('status', array(
						'draft' => 'Draft',
						'published' => 'Published'
					), $stream->status); ?>
				</div>
			<?php endif; ?>
			
			<div class="final-row">
				<?php echo form_submit('submit', 'Update'); ?>
				<a href="/admin/streams/index/" class="cancel">Cancel</a>
			</div>
		</div>
		
	
		
		<div id="form-content">	
			<h2 class="form-head">Edit Stream</h2>
			<div class="form-row title">
				<label>Streamer Username (Twitch.tv)</label>
				<?php echo form_input('title', $stream->title); ?>
			</div>
			<div class="form-row">
				
				<div class="form-half">
					<label>Stream Classification</label>
					<?php echo form_dropdown('section_id', $sections, $stream->section_id); ?>
				</div>
				<div class="form-half">
					<label>Stream Game</label>
					<?php echo form_dropdown('category_id', $categories, $stream->category_id); ?>
				</div>
			</div>
		</div>
	</form>
</div>

