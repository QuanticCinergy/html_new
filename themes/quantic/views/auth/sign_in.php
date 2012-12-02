<div id="content" class="has-side">
			

<h1 id="page-title">Log in</h1>


<div id="sign-in">
<?php echo partial('validation'); ?>
  <?php echo collect('message'); ?>
	
    <?php echo form_open(login_url());?>
    	
      <div class="form-row">
      	<label for="email">Email</label>
      	<?php echo form_input('email');?>
      </div>
      
      <div class="form-row">
      	<label for="password">Password</label>
      	<?php echo form_password('password');?>
      </div>
      
      <div class="form-row">
	      <label for="remember" class="not-text">Remember me?</label>
	      <?php echo form_checkbox('remember', '1', FALSE);?>
	      <span class="generic_surround float-right"><?php echo form_submit('submit', 'Sign In');?></span>
	  </div>
          
    <?php echo form_close();?>
	<div class="form-row">
    		<p>Not got an account? <?php echo link_to('Register', register_url()); ?></p>
    	</div>
	    	
    	<div id="social-sign-in">
		<p>Don't fancy filling in the form? You can sign in using the following social networks.</p>
		<span class="tw_button"><?php echo link_to('Sign in with Twitter', 'auth/twt_sign_in'); ?></span>
		<span class="fb_button"><?php echo link_to('Sign in with Facebook', 'auth/fb_sign_in'); ?></span>
		</div>

    
</div>

<div class="forgot-pass"><p><a href="/auth/forgot_password">Forget your password?</a></p></div>


</div>

