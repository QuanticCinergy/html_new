<?php spotlight('sponsors'); ?>

<div id="content" class="has-side margin-top">

	<h1 id="page-title">Our Teams</h1>

	<ul id="team">
	<?php foreach(fetch('squads') as $squad) : ?>
	<li>
		<h2><?php echo $squad->name; ?></h2>
		<?php echo $squad->description; ?>
		<ul class="members">
			<?php foreach($squad->members as $member) : ?>
			
				<?php if($member): ?>
					<li class="member"><?php echo link_to('<img src="'.$member->user->avatar().'" width="100" height="100" title="'.$member->user->username.'">', '/profile/'.$member->user->username); ?></li>
				<?php endif;?>
				
			<?php endforeach; ?>
		</ul>
	</li>
	<?php endforeach; ?>
	</ul>

	<script>
		$(".member img[title]").tooltip();
	</script>

</div>

<?php sidebar('main')?>
