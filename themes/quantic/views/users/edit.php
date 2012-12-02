<div id="content" class="has-side <?php if($user->group_id == 1):?>admin<?php endif; ?>">

	<section id="user-header">
	
	<ul class="breadcrumb">
		<li><h2>Members</h2></li>
		<li><?= $user->full_name(); ?></li>
		<li class="here">Edit Profile</li>
	</ul>

<h1 id="page-title">Edit Profile</h1>

<div class="main-form">
	<?php echo partial('validation'); ?>
	<?php echo form_open_multipart('profile/update'); ?>

	<fieldset>
		<h2>Personal</h2>
		<div class="form-row" style="margin-top:0;">
			<div class="form-half"><label>Username</label> <?php echo form_input('user[username]', $user->username); ?></div>
			<div class="form-half"><label>Email</label> <?php echo form_input('user[email]', $user->email); ?></div>
		</div>
		<div class="form-row">
			<div class="form-half"><label>First Name</label> <?php echo form_input('meta[first_name]', $user->first_name); ?></div>
			<div class="form-half"><label>Last Name</label> <?php echo form_input('meta[last_name]', $user->last_name); ?></div>
		</div>
		
		<div class="form-row">
			<div class="form-half"><label>Website</label> <?php echo form_input('meta[website]', $user->website); ?></div>
			<div class="form-half"><label>Twitter</label> <?php echo form_input('meta[twitter]', $user->twitter); ?></div>
		</div>
		
		<div class="form-row">
			<div class="form-half"><label>Date of Birth (eg. 26th March 1970)</label> <?php echo form_input('meta[age]', $user->age); ?></div>
			<div class="form-half"><label>Location</label> <?php echo form_input('meta[location]', $user->location); ?></div>
		</div>
		<div class="form-row">
			<label>About me (140 character limit)</label>
			 <?php echo form_input('meta[about]', $user->about); ?>
		</div>
		<div class="form-row">
			<label>Timezone</label>
			<select size="1" name="user[timezone]"><?php partial('timezones'); ?></select>
		</div>
		
	</fieldset>


	<fieldset>
		<h2>Your Avatar</h2>
		<div class="form-row">
			
			<div class="form-half">
				<?php if(!empty($user->avatar_thumb_url)) :?><img class="current-avatar" src="<?php echo $user->avatar_thumb_url; ?>" /><?php endif; ?>
			</div>
			
			<div class="form-half">
				<label>Upload New Photo</label><?php echo form_upload('avatar'); ?>
			</div>
			
			
			
		</div>
	</fieldset>
	
	
	<fieldset>
		<h2>Change Password</h2>
		<p class="fyi">Only fill this to change your password.</p>
		<div class="form-row">
			<div class="form-half"><label>Password</label> <?php echo form_password('user[password]'); ?></div>
			<div class="form-half"><label>Confirm</label> <?php echo form_password('password'); ?></div>
		</div>
	</fieldset>
		<span class="generic_surround"><?php echo form_submit('submit', 'Update'); ?></span>
		<?php echo link_to('Cancel', 'profile'); ?>
	</form>
	
</div>


</div>

<?php sidebar('main'); ?>
