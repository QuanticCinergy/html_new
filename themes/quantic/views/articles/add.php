<div id="content" class="has-side articles">

<h1 id="page-title">Write an article</h1>
	

    <span class="generic_button"><a href="/profile/posts">Back</a></span>
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
				<label>Intro</label>
				<?php echo form_textarea('short_content', '', 'class="short"'); ?>
			</div>
			<div class="form-row">
				<label>Full content</label>
				<?php echo form_textarea('content', '', 'class="full"'); ?><br>
			</div>
		
		</div>

		<div id="form-final">
			<div class="final-row">
				<label>Image</label>
				<?php echo form_upload('image'); ?>
			</div>
			<div class="final-row">
				<label>Status</label>
				<?php echo form_dropdown('status', array(
					'draft' => 'Draft',
					'submitted' => 'Submit for approval'
				), 'draft'); ?>
			</div>
			<div class="final-row">
				<?php echo form_submit('submit', 'Create'); ?>
				<a href="/profile/posts" class="cancel">Cancel</a>
			</div>
		</div>
		
	</form>

</div>