<div id="content" class="has-side articles">

<ul class="breadcrumb">
		<li><h2>Your Posts</h2></li>
		<li class="here">New Post</li>
	</ul>
			
	<h1 id="page-title">Write new post</h1>
	

    <span class="generic_button float-left"><a href="/profile/posts/">Back</a></span>
	
	<?php echo partial('validation'); ?>
	<?php echo form_open_multipart('profile/posts/create'); ?>
		
		<div id="form-content">
			<div class="form-row">
				<label>Title</label>
				<?php echo form_input('title'); ?>
			</div>
			<div class="form-row">
					<label>Category</label>
					<?php echo form_dropdown('category_id', $categories); ?>
			</div>
			
			<div class="form-row">
				<label>Attach Games</label>
				<input type="text" name="games" class="games-tokeninput">
			</div>
			
			<div class="form-row">
				<label>Intro</label>
				<?php echo form_textarea('short_content', '', 'class="short"'); ?>
			</div>
			<div class="form-row">
				<label>Full content</label>
				<?php echo form_textarea('content', '', 'class="full"'); ?><br>
			</div>
		
		</div>

		<div id="form-final">
			<div class="form-row">
				<label>Image</label>
				<?php echo form_upload('image'); ?>
			</div>
			<div class="form-row">
				<?php echo form_submit('submit', 'Create'); ?>
				<a href="/profile/posts" class="cancel">Cancel</a>
			</div>
		</div>
		
	</form>

</div>

<?php sidebar('main'); ?>

<script src="<?=site_url('themes/made2game/assets/js/jquery.tokeninput.min.js');?>" type="text/javascript"></script>
<script src="<?=site_url('themes/made2game/assets/js/init-games-tokeninputs.js');?>" type="text/javascript"></script>