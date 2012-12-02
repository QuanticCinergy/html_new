<script>
	// perform JavaScript after the document is scriptable.
	$(function() {
	// setup ul.tabs to work as tabs for each div directly under div.panes
	$("ul.profile-tabs").tabs("div.sections > div", {
		effect: 'fade',
	
	});
	}); 
</script>

<div id="content" class="has-side <?php if($user->group_id == 1):?>admin<?php endif; ?>">

	<section id="user-header">
	
	<ul class="breadcrumb">
		<li><h2>Members</h2></li>
		<li><?= $user->full_name(); ?></li>
		<li class="here">Profile</li>
	</ul>
	
	
	<div class="my-avatar"><?php echo img($user->avatar()); ?></div>
	<?php if($user->id == current_user()->id) : ?>
	<span class="generic_button float-right "><?php echo link_to('Edit Profile', edit_profile_url());?> </span>
	<?php endif; ?>
	<h1 id="page-title"><?php echo $user->username; ?></h1>
	
	
	<div class="status">
	<div class="quote-mark"></div><?= $user->status; ?></div>
	
	</section>

	
	<section id="hardware">
	
	
	<div class="sections">	
	<div class="pane">
	
	<div id="user-info">
	
	<h2>User Information</h2>
	
	<ul>
		<li><span>Real Name</span><?= $user->full_name(); ?></li>
		<?php if(!empty($user->age)) : ?><li><span>Date of Birth</span><?= $user->age; ?></li><?php endif; ?>
		<?php if(!empty($user->location)) : ?><li><span>Location</span><?= $user->location; ?></li><?php endif; ?>
		<?php if(!empty($user->website)) : ?><li><span>Website</span><a href="<?= $user->website; ?>"><?= $user->website; ?></a></li><?php endif; ?>
		<?php if(!empty($user->twitter)) : ?><li><span>Twitter</span><a href="http://twitter.com/<?= $user->twitter; ?>"><?= $user->twitter; ?></a></li><?php endif; ?>
	</ul>
	
		<p class="about">
		<span>About <?= $user->full_name(); ?></span><?= $user->about; ?></p>
	
	</div>
	
	</div>
	
	
	
		
	</div>
	
	</section>	

	
</div>
<?php sidebar('main'); ?>
