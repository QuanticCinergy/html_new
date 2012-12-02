<div id="content" class="has-side">
	<h1 id="page-title">Create new message</h1>
	<?php echo form_open('profile/messages/create'); ?>
	<div class="form-row">
	<label>To</label>
	<?php echo is_array($receiver) ? form_dropdown('receiver_id', $receiver) : form_hidden('receiver_id', $receiver->id).'<h2>'.$receiver->username.'</h2>'; ?>
	</div>
	
	<div class="form-row">
		<label>Subject</label><?php echo form_input('subject', $subject); ?>
		<?php if(param('reply')) { echo form_hidden('reply_to', param('reply')); } ?>
	</div>
	<div class="form-row">
		<?php echo form_textarea('content'); ?>
	</div>
	
	<div class="form-row">
		<?php echo form_submit('submit', 'Send!', '.generic_button float-left'); ?>
	</div>
	</form>
</div>
