<div id="content">
	<h1 id="page-title">Create Thread</h1>

	<div class="main-form">
	
	<?= partial('validation') ?>
	<?= form_open(create_forum_thread_url(param('name'))) ?>
	<?= form_hidden('forum_name', param('name')) ?>
	<div class="form-row">
		<label>Title</label>
		<?= form_input('title') ?>
	</div>
	<div class="form-row">
		<?= form_textarea('content') ?><br>
	</div>
	<span class="generic_surround"><?= form_submit('submit', 'Submit') ?></span>
	</form>

	</div>

</div>
