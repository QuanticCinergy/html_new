<div id="content" class="has-side articles">

<h1 id="page-title">Edit an article</h1>

	<span class="generic_button"><a href="/profile/posts">Back</a></span>
	<?php echo partial('validation'); ?>
	<?php echo form_open_multipart('profile/posts/update'); ?>
	<?php echo form_hidden('id', param('id')); ?>
		<div id="form-final">
			<div class="final-row">
				<label>Article Image</label>
				<?php echo img($article->image_article_url); ?>
				<?php echo form_upload('image'); ?>
			</div>	
			<div class="final-row">
				<label>Date (click to change) </label>
				<input type="text" value="<?= date('d-m-Y G:i', $article->original_created_at) ?>" name="created_at" class="date" />
			</div>
			<div class="final-row">
				<label>Publish Status</label>
				<?php echo form_dropdown('status', array(
					'draft' => 'Draft',
					'submitted' => 'Re-submit for approval'
				), $article->status); ?>
			</div>
			<div class="final-row">
				<?php echo form_submit('submit', 'Update'); ?>
				<a href="/profile/posts" class="cancel">Cancel</a>
			</div>
		</div>
		
		<div id="form-content">	
			<div class="form-row title">
				<label>Title</label>
				<?php echo form_input('title', $article->title); ?>
			</div>
			<div class="form-row">
					<label>Category</label>
					<?php echo form_dropdown('category_id', $categories, $article->category_id); ?>
			</div>
			<div class="form-row">
				<label>Intro</label>
				<?php echo form_textarea('short_content', $article->short_content, 'class="short"'); ?>
			</div>
			<div class="form-row">
				<label>Full content</label>
				<?php echo form_textarea('content', $article->content, 'class="full"'); ?>
			</div>
		</div>
	</form>
</div>
