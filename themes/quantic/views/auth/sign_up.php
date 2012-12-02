<div id="content" class="has-side">
	<h1 id="page-title">Registration</h1>
	

	<div id="sign-in">
		<p>Simply fill in the following details to set up your free account.</p>
	
	<?php echo partial('validation'); ?>
	
	<?php echo flash('message'); ?>	
		
	    <?php echo form_open("auth/sign_up");?>
   	     <div class="form-row">
	      	<label>Username</label>
	     	<?php echo form_input('username'); ?>
   	     </div>

	     <div class="form-row">
		    <label>Email</label>
		 	<?php echo form_input('email');?>
	     </div>

   	     <div class="form-row">
   	     	<div class="fyi dark">Your password must be longer than 6 characters.</div>
	    	<label>Password</label>
		    <?php echo form_password('password');?>
	     </div>
	     <div class="form-row">
		    <label>Confirm password</label>
	     	<?php echo form_password('password_confirm');?>
	     </div>    

      	<span class="generic_surround float-right"><?php echo form_submit('submit', 'Register');?></span>
	<?php echo form_close();?>
	
	<div id="social-sign-in">
		<p>Don't fancy filling in the form? You can register using the following social networks.</p>
		<span class="tw_button"><?php echo link_to('Sign in with Twitter', 'auth/twt_sign_in'); ?></span>
		<span class="fb_button"><?php echo link_to('Sign in with Facebook', 'auth/fb_sign_in'); ?></span>
	</div>
	
	</div>

	

</div>
