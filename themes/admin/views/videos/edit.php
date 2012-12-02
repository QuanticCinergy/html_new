<h1>Edit Video</h1>

<div id="subnav"> 
				<ul> 
					<li><a href="/admin/galleries/index/">Galleries</a></li> 
					<li class="active"><a href="/admin/videos/index/">Videos</a></li>
					<li><a href="/admin/video_categories/index/">Video Categories</a></li> 
				</ul> 
			</div> 
			
	<div id="mainbody" class="with-subnav"> 

		<?php echo partial('validation'); ?>
		<?php echo form_open('admin/videos/update'); ?>
		<?php echo form_hidden('id', param('id')); ?>
		<div class="form-row">
			<label>Title</label>
			<?php echo form_input('title', $video->title); ?>
		</div>
		<div class="form-row">
			<label>Category</label>
			<?php echo form_dropdown('category_id', $categories, $video->category_id); ?>
		</div>
		<div class="form-row">
			<label>Video URL</label>
			<?php echo form_input('video_url', $video_url); ?>
		</div>
		<div class="form-row">
			<?php echo form_submit('submit', 'Update'); ?>
		</div>
		</form>
	
	</div>
