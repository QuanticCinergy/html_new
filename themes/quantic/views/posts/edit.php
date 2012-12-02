<div id="content" class="has-side articles">

<ul class="breadcrumb">
		<li><h2>Your Posts</h2></li>
		<li>Edit</li>
		<li class="here"><?= $post->title; ?></li>
	</ul>
			
	<h1 id="page-title">Edit your post</h1>
	

    <span class="generic_button float-left"><a href="/profile/posts/">Back</a></span>

	<?php echo partial('validation'); ?>
	<?php echo form_open_multipart('userpost/update'); ?>
	<?php echo form_hidden('id', param('id')); ?>
		
		<div id="form-content">	
			<div class="form-row title">
				<label>Title</label>
				<?php echo form_input('title', $post->title); ?>
			</div>
			<div class="form-row">
					<label>Category</label>
					<?php echo form_dropdown('category_id', $categories, $post->category_id); ?>
			</div>
			
			<div class="form-row">
				<label>Attach Games</label>
				<script>window.onload = function(){pop('<?php echo $games_json; ?>');}</script>
				<input type="text" name="games" class="games-tokeninput">
				<br /><br />
			</div>
			
			<div class="form-row">
				<label>Intro</label>
				<?php echo form_textarea('short_content', $post->short_content, 'class="short"'); ?>
			</div>
			<div class="form-row">
				<label>Full content</label>
				<?php echo form_textarea('content', $post->content, 'class="full"'); ?>
			</div>
		
		<div id="form-final">
			<div class="form-row">
				<label>Post Image</label>
				
				<div class="current-image"><?php echo img($post->image_url); ?></div>
				<?php echo form_upload('image'); ?>
			</div>	
			
			<div class="final-row">
				<?php echo form_submit('submit', 'Update'); ?>
				<a href="/profile/posts" class="cancel">Cancel</a>
			</div>
		</div>
		</div>
	</form>
</div>

<?php sidebar('main'); ?>

<script src="<?=site_url('themes/made2game/assets/js/jquery.tokeninput.min.js');?>" type="text/javascript"></script>
<script src="<?=site_url('themes/made2game/assets/js/init-games-tokeninputs.js');?>" type="text/javascript"></script>